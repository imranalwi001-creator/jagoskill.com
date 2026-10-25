<?php

namespace App\Services\DigitalProducts;

use App\Models\Product;
use App\Models\ProductDownloadLog;
use App\Models\ProductFile;
use App\Models\ProductOrder;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SecureDownloadService
{
    /**
     * Handle secure download of a digital product file
     *
     * @param ProductFile $file
     * @param User $user
     * @param Request|null $request
     * @return BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function download(ProductFile $file, User $user, ?Request $request = null)
    {
        $request = $request ?: request();
        $product = $file->product;

        if (empty($product) || $product->status !== Product::$active) {
            return $this->errorResponse('Produk tidak aktif atau tidak ditemukan.');
        }

        // If external link, redirect directly
        if ($file->isExternalLink()) {
            return redirect()->away($file->external_link);
        }

        // Check ownership or creator or admin access
        $order = null;
        $canAccess = false;

        if ($user->isAdmin() || $product->creator_id == $user->id) {
            $canAccess = true;
        } else {
            $order = ProductOrder::where('product_id', $product->id)
                ->where(function ($query) use ($user) {
                    $query->where('buyer_id', $user->id);
                })
                ->whereHas('sale', function ($query) {
                    $query->whereNull('refund_at')
                        ->where('access_to_purchased_item', 1);
                })
                ->whereIn('status', [ProductOrder::$success, ProductOrder::$shipped])
                ->latest('id')
                ->first();

            if (!empty($order)) {
                $canAccess = true;
            }
        }

        if (!$canAccess) {
            return $this->errorResponse(trans('public.not_access_toast_msg_lang'));
        }

        // Check download limit (for non-admin, non-creator)
        if (!$user->isAdmin() && $product->creator_id != $user->id) {
            if (!empty($file->download_limit) && $file->download_limit > 0) {
                $usedDownloads = ProductDownloadLog::where('product_file_id', $file->id)
                    ->where('user_id', $user->id)
                    ->count();

                if ($usedDownloads >= $file->download_limit) {
                    return $this->errorResponse("Batas maksimal unduhan ({$file->download_limit} kali) untuk file ini telah tercapai.");
                }
            }
        }

        // Resolve file path
        $filePath = $this->resolveFilePath($file);

        if (!$filePath || !file_exists($filePath)) {
            return $this->errorResponse('File tidak ditemukan di server penyimpanan. Silakan hubungi dukungan pelanggan.');
        }

        // Record audit log
        $this->recordDownloadLog($file, $user, $order ? $order->id : null, $request);

        // Sanitize download filename
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        if (empty($extension)) {
            $extension = $file->file_type ?: 'bin';
        }
        $safeName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $file->title);
        $downloadFilename = "{$safeName}.{$extension}";

        return response()->download($filePath, $downloadFilename, [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, private',
            'Pragma' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Resolve the physical path for a product file (supports private storage and legacy public path)
     *
     * @param ProductFile $file
     * @return string|null
     */
    public function resolveFilePath(ProductFile $file): ?string
    {
        $rawPath = ltrim($file->path, '/');

        // Check storage/app/private/
        $privatePath = storage_path('app/private/' . $rawPath);
        if (file_exists($privatePath)) {
            return $privatePath;
        }

        // Check storage/app/
        $storageAppPath = storage_path('app/' . $rawPath);
        if (file_exists($storageAppPath)) {
            return $storageAppPath;
        }

        // Check public/
        $publicPath = public_path($rawPath);
        if (file_exists($publicPath)) {
            return $publicPath;
        }

        return null;
    }

    /**
     * Record download audit log
     */
    private function recordDownloadLog(ProductFile $file, User $user, ?int $orderId, Request $request): void
    {
        try {
            ProductDownloadLog::create([
                'product_file_id' => $file->id,
                'product_id' => $file->product_id,
                'product_order_id' => $orderId,
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => substr((string)$request->userAgent(), 0, 500),
                'created_at' => time(),
            ]);
        } catch (\Throwable $e) {
            // Non-blocking log failure
            \Log::warning("Could not record download log: " . $e->getMessage());
        }
    }

    /**
     * Return formatted error response
     */
    private function errorResponse(string $message)
    {
        $toastData = [
            'title' => trans('public.request_failed'),
            'msg' => $message,
            'status' => 'error'
        ];

        return back()->with(['toast' => $toastData]);
    }
}
