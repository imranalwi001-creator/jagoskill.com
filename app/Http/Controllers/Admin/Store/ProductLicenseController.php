<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductLicense;
use App\Models\ProductLicenseActivation;
use App\Services\DigitalProducts\LicenseService;
use App\User;
use Illuminate\Http\Request;

class ProductLicenseController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('admin_store_products');

        $query = ProductLicense::query()->with(['product', 'user', 'order']);

        $search = $request->get('search');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('license_key', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($qu) use ($search) {
                        $qu->where('full_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('product', function ($qp) use ($search) {
                        $qp->where('title', 'like', "%{$search}%");
                    });
            });
        }

        $status = $request->get('status');
        if (!empty($status) && in_array($status, ['active', 'inactive', 'revoked'])) {
            $query->where('status', $status);
        }

        $productId = $request->get('product_id');
        if (!empty($productId)) {
            $query->where('product_id', $productId);
        }

        $totalLicenses = ProductLicense::count();
        $activeLicenses = ProductLicense::where('status', ProductLicense::STATUS_ACTIVE)->count();
        $revokedLicenses = ProductLicense::where('status', ProductLicense::STATUS_REVOKED)->count();
        $totalActivations = ProductLicenseActivation::count();

        $licenses = $query->orderBy('created_at', 'desc')->paginate(15);
        $products = Product::where('type', Product::$virtual)->select('id')->get();

        $data = [
            'pageTitle' => 'Manajemen Lisensi Digital',
            'licenses' => $licenses,
            'products' => $products,
            'totalLicenses' => $totalLicenses,
            'activeLicenses' => $activeLicenses,
            'revokedLicenses' => $revokedLicenses,
            'totalActivations' => $totalActivations,
        ];

        return view('admin.store.licenses.lists', $data);
    }

    public function generate(Request $request)
    {
        $this->authorize('admin_store_products');

        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'count' => 'required|integer|min:1|max:100',
            'max_activations' => 'required|integer|min:1',
            'days_valid' => 'nullable|integer|min:1',
        ]);

        $productId = $request->get('product_id');
        $count = (int)$request->get('count', 1);
        $maxActivations = (int)$request->get('max_activations', 1);
        $daysValid = $request->get('days_valid');
        $userId = $request->get('user_id');

        $expiresAt = !empty($daysValid) ? time() + ($daysValid * 86400) : null;
        $licenseService = new LicenseService();

        for ($i = 0; $i < $count; $i++) {
            $key = $licenseService->generateKey();

            ProductLicense::create([
                'product_id' => $productId,
                'user_id' => !empty($userId) ? $userId : null,
                'product_order_id' => null,
                'license_key' => $key,
                'status' => ProductLicense::STATUS_ACTIVE,
                'max_activations' => $maxActivations,
                'activation_count' => 0,
                'expires_at' => $expiresAt,
                'created_at' => time(),
                'updated_at' => time(),
            ]);
        }

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => "Berhasil men-generate {$count} serial key lisensi baru.",
            'status' => 'success'
        ];

        return back()->with(['toast' => $toastData]);
    }

    public function changeStatus(Request $request, $id)
    {
        $this->authorize('admin_store_products');

        $license = ProductLicense::findOrFail($id);
        $status = $request->get('status');

        if (in_array($status, ['active', 'inactive', 'revoked'])) {
            $license->update([
                'status' => $status,
                'updated_at' => time(),
            ]);

            return response()->json([
                'code' => 200,
                'msg' => 'Status lisensi berhasil diperbarui.'
            ]);
        }

        return response()->json(['code' => 422, 'msg' => 'Status tidak valid.'], 422);
    }

    public function resetActivations(Request $request, $id)
    {
        $this->authorize('admin_store_products');

        $license = ProductLicense::findOrFail($id);
        $license->activations()->delete();
        $license->update([
            'activation_count' => 0,
            'updated_at' => time(),
        ]);

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => "Seluruh aktivasi domain untuk lisensi {$license->license_key} berhasil direset.",
            'status' => 'success'
        ];

        return back()->with(['toast' => $toastData]);
    }

    public function activations($id)
    {
        $this->authorize('admin_store_products');

        $license = ProductLicense::with('activations')->findOrFail($id);

        return response()->json([
            'code' => 200,
            'license_key' => $license->license_key,
            'activations' => $license->activations,
        ]);
    }
}
