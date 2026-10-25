<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DigitalProducts\LicenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LicenseApiController extends Controller
{
    protected $licenseService;

    public function __construct()
    {
        $this->licenseService = new LicenseService();
    }

    /**
     * Verify license key validity
     * POST /api/v1/licenses/verify
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'license_key' => 'required|string',
            'domain' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'valid' => false,
                'error' => 'VALIDATION_FAILED',
                'messages' => $validator->errors(),
            ], 422);
        }

        $result = $this->licenseService->verifyLicense(
            $request->input('license_key'),
            $request->input('domain')
        );

        $status = $result['valid'] ? 200 : 400;
        return response()->json($result, $status);
    }

    /**
     * Activate license on a domain or machine
     * POST /api/v1/licenses/activate
     */
    public function activate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'license_key' => 'required|string',
            'domain' => 'required|string',
            'machine_id' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'VALIDATION_FAILED',
                'messages' => $validator->errors(),
            ], 422);
        }

        $result = $this->licenseService->activateLicense(
            $request->input('license_key'),
            $request->input('domain'),
            $request->ip(),
            $request->input('machine_id'),
            $request->userAgent()
        );

        $status = ($result['success'] ?? false) ? 200 : 422;
        return response()->json($result, $status);
    }

    /**
     * Deactivate a domain from a license
     * POST /api/v1/licenses/deactivate
     */
    public function deactivate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'license_key' => 'required|string',
            'domain' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'VALIDATION_FAILED',
                'messages' => $validator->errors(),
            ], 422);
        }

        $result = $this->licenseService->deactivateLicense(
            $request->input('license_key'),
            $request->input('domain')
        );

        $status = ($result['success'] ?? false) ? 200 : 404;
        return response()->json($result, $status);
    }
}
