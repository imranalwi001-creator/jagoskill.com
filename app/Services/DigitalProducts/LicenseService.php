<?php

namespace App\Services\DigitalProducts;

use App\Models\Product;
use App\Models\ProductLicense;
use App\Models\ProductLicenseActivation;
use App\Models\ProductOrder;
use App\User;
use Illuminate\Support\Str;

class LicenseService
{
    /**
     * Generate a cryptographically secure license key
     * Format: JAGO-XXXX-XXXX-XXXX
     *
     * @param string $prefix
     * @return string
     */
    public function generateKey(string $prefix = 'JAGO'): string
    {
        do {
            $part1 = strtoupper(Str::random(4));
            $part2 = strtoupper(Str::random(4));
            $part3 = strtoupper(Str::random(4));
            $key = "{$prefix}-{$part1}-{$part2}-{$part3}";
        } while (ProductLicense::where('license_key', $key)->exists());

        return $key;
    }

    /**
     * Automatically assign a license key to a digital product order
     *
     * @param ProductOrder $productOrder
     * @param int $maxActivations
     * @param int|null $daysValid
     * @return ProductLicense
     */
    public function assignLicenseToOrder(ProductOrder $productOrder, int $maxActivations = 1, ?int $daysValid = null): ProductLicense
    {
        // Check if order already has an assigned license
        $existing = ProductLicense::where('product_order_id', $productOrder->id)->first();
        if ($existing) {
            return $existing;
        }

        $expiresAt = null;
        if (!empty($daysValid) && $daysValid > 0) {
            $expiresAt = time() + ($daysValid * 86400);
        }

        $key = $this->generateKey();

        return ProductLicense::create([
            'product_id' => $productOrder->product_id,
            'product_order_id' => $productOrder->id,
            'user_id' => $productOrder->buyer_id,
            'license_key' => $key,
            'status' => ProductLicense::STATUS_ACTIVE,
            'max_activations' => $maxActivations,
            'activation_count' => 0,
            'expires_at' => $expiresAt,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * Verify license validity
     *
     * @param string $licenseKey
     * @param string|null $domain
     * @return array
     */
    public function verifyLicense(string $licenseKey, ?string $domain = null): array
    {
        $license = ProductLicense::where('license_key', trim($licenseKey))->with('product')->first();

        if (!$license) {
            return [
                'valid' => false,
                'error_code' => 'NOT_FOUND',
                'message' => 'Lisensi tidak ditemukan atau tidak valid.',
            ];
        }

        if ($license->status !== ProductLicense::STATUS_ACTIVE) {
            return [
                'valid' => false,
                'error_code' => 'SUSPENDED_OR_REVOKED',
                'message' => 'Lisensi ini telah dinonaktifkan atau dicabut.',
                'status' => $license->status,
            ];
        }

        if (!empty($license->expires_at) && $license->expires_at < time()) {
            return [
                'valid' => false,
                'error_code' => 'EXPIRED',
                'message' => 'Masa berlaku lisensi ini telah kedaluwarsa pada ' . date('d M Y', $license->expires_at),
                'expires_at' => $license->expires_at,
            ];
        }

        $isDomainActive = false;
        if (!empty($domain)) {
            $cleanDomain = $this->sanitizeDomain($domain);
            $isDomainActive = $license->activations()->where('domain', $cleanDomain)->exists();
        }

        return [
            'valid' => true,
            'license_key' => $license->license_key,
            'product_title' => $license->product ? $license->product->title : 'Digital Product',
            'max_activations' => $license->max_activations,
            'activation_count' => $license->activation_count,
            'remaining_activations' => $license->remaining_activations,
            'expires_at' => $license->expires_at ? date('Y-m-d H:i:s', $license->expires_at) : 'Lifetime',
            'domain_active' => $isDomainActive,
        ];
    }

    /**
     * Activate a license on a specific domain or machine
     *
     * @param string $licenseKey
     * @param string $domain
     * @param string|null $ip
     * @param string|null $machineId
     * @param string|null $userAgent
     * @return array
     */
    public function activateLicense(string $licenseKey, string $domain, ?string $ip = null, ?string $machineId = null, ?string $userAgent = null): array
    {
        $verify = $this->verifyLicense($licenseKey, $domain);
        if (!$verify['valid']) {
            return $verify;
        }

        $license = ProductLicense::where('license_key', trim($licenseKey))->first();
        $cleanDomain = $this->sanitizeDomain($domain);

        // Check if already activated on this domain
        $existing = $license->activations()->where('domain', $cleanDomain)->first();
        if ($existing) {
            return [
                'success' => true,
                'already_activated' => true,
                'message' => "Lisensi sudah aktif untuk domain {$cleanDomain}.",
                'license' => $verify,
            ];
        }

        // Check quota
        if (!$license->canActivate()) {
            return [
                'success' => false,
                'error_code' => 'ACTIVATION_LIMIT_EXCEEDED',
                'message' => "Batas maksimal aktivasi ({$license->max_activations}) telah tercapai. Silakan reset aktivasi domain lama di dashboard.",
            ];
        }

        // Register activation
        ProductLicenseActivation::create([
            'license_id' => $license->id,
            'domain' => $cleanDomain,
            'ip_address' => $ip,
            'machine_id' => $machineId,
            'user_agent' => substr((string)$userAgent, 0, 500),
            'activated_at' => time(),
        ]);

        $license->increment('activation_count');
        $license->update(['updated_at' => time()]);

        return [
            'success' => true,
            'already_activated' => false,
            'message' => "Lisensi berhasil diaktivasi untuk domain {$cleanDomain}.",
            'activations_remaining' => max(0, $license->max_activations - $license->activation_count),
        ];
    }

    /**
     * Deactivate a domain from a license
     *
     * @param string $licenseKey
     * @param string $domain
     * @return array
     */
    public function deactivateLicense(string $licenseKey, string $domain): array
    {
        $license = ProductLicense::where('license_key', trim($licenseKey))->first();
        if (!$license) {
            return ['success' => false, 'message' => 'Lisensi tidak ditemukan.'];
        }

        $cleanDomain = $this->sanitizeDomain($domain);
        $deleted = $license->activations()->where('domain', $cleanDomain)->delete();

        if ($deleted) {
            $newCount = $license->activations()->count();
            $license->update([
                'activation_count' => $newCount,
                'updated_at' => time(),
            ]);

            return ['success' => true, 'message' => "Domain {$cleanDomain} berhasil dinonaktifkan."];
        }

        return ['success' => false, 'message' => 'Domain tidak ditemukan dalam daftar aktivasi.'];
    }

    /**
     * Revoke license for an order (e.g. on refund or chargeback)
     *
     * @param int $orderId
     * @return bool
     */
    public function revokeLicenseForOrder(int $orderId): bool
    {
        $license = ProductLicense::where('product_order_id', $orderId)->first();
        if ($license) {
            $license->update([
                'status' => ProductLicense::STATUS_REVOKED,
                'updated_at' => time(),
            ]);
            return true;
        }
        return false;
    }

    /**
     * Clean and normalize domain name
     */
    private function sanitizeDomain(string $url): string
    {
        $url = trim($url);
        if (!preg_match('#^https?://#i', $url)) {
            $url = 'http://' . $url;
        }
        $host = parse_url($url, PHP_URL_HOST);
        return strtolower(preg_replace('/^www\./i', '', $host ?: $url));
    }
}
