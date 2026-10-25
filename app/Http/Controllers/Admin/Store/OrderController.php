<?php

namespace App\Http\Controllers\Admin\Store;

use App\Exports\StoreOrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Accounting;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('admin_store_products_orders');

        $query = ProductOrder::where('status', '!=', ProductOrder::$pending)
            ->whereNotNull('sale_id');

        return $this->returnDataToView($request, $query);
    }

    private function handleTopStats($query, $status = null): array
    {
        if (!empty($status)) {
            $query->where('status', $status);
        }

        $query->join('sales', 'sales.id', 'product_orders.sale_id')
            ->select('product_orders.*', 'sales.total_amount');
        $orders = $query->get();

        return [
            'count' => $orders->count(),
            'amount' => $orders->sum('total_amount'),
        ];
    }

    private function getFilters($query, $request)
    {
        $item_title = $request->get('item_title');
        $from = $request->get('from');
        $to = $request->get('to');
        $status = $request->get('status');
        $sellerIds = $request->get('seller_ids', []);
        $customerIds = $request->get('customer_ids', []);

        if (!empty($item_title)) {
            $ids = Product::whereTranslationLike('title', "%$item_title%")->pluck('id')->toArray();

            $query->whereIn('product_id', $ids);
        }

        $query = fromAndToDateFilter($from, $to, $query, 'created_at');

        if (!empty($status)) {
            $query->where('status', $status);
        }

        if (!empty($sellerIds) and count($sellerIds)) {
            $query->whereIn('seller_id', $sellerIds);
        }

        if (!empty($customerIds) and count($customerIds)) {
            $query->whereIn('buyer_id', $customerIds);
        }

        return $query;
    }

    private function returnDataToView(Request $request, $query, $inHouseOrders = false)
    {
        $successOrders = $this->handleTopStats(deepClone($query), ProductOrder::$success);

        $canceledOrders = $this->handleTopStats(deepClone($query), ProductOrder::$canceled);

        $waitingOrders = $this->handleTopStats(deepClone($query), ProductOrder::$waitingDelivery);

        $totalOrders = $this->handleTopStats(deepClone($query));

        $query = $this->getFilters($query, $request);

        $orders = $query->with([
            'product',
            'seller' => function ($query) {
                $query->select('id', 'full_name');
            },
            'buyer' => function ($query) {
                $query->select('id', 'full_name', 'email');
            },
            'sale',
            'license',
            'downloadLogs',
        ])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $data = [
            'pageTitle' => trans('update.orders_lists'),
            'orders' => $orders,
            'successOrders' => $successOrders,
            'canceledOrders' => $canceledOrders,
            'waitingOrders' => $waitingOrders,
            'totalOrders' => $totalOrders,
            'inHouseOrders' => $inHouseOrders
        ];

        $sellerIds = $request->get('seller_ids', []);
        $customerIds = $request->get('customer_ids', []);

        if (!empty($sellerIds) and count($sellerIds)) {
            $data['sellers'] = User::select('id', 'full_name')
                ->whereIn('id', $sellerIds)->get();
        }

        if (!empty($customerIds) and count($customerIds)) {
            $data['customers'] = User::select('id', 'full_name')
                ->whereIn('id', $customerIds)->get();
        }

        return view('admin.store.orders.lists', $data);
    }

    public function inHouseOrders(Request $request)
    {
        $this->authorize('admin_store_in_house_orders');

        removeContentLocale();

        $adminRoleIds = Role::where('is_admin', true)->pluck('id')->toArray();

        $query = ProductOrder::where('product_orders.status', '!=', ProductOrder::$pending)
            ->whereHas('seller', function ($query) use ($adminRoleIds) {
                $query->whereIn('role_id', $adminRoleIds);
            })
            ->whereNotNull('sale_id');

        return $this->returnDataToView($request, $query, true);
    }

    public function refund($id)
    {
        $this->authorize('admin_store_products_orders_refund');

        $productOrder = ProductOrder::where('id', $id)->first();

        if (!empty($productOrder) and !empty($productOrder->sale)) {
            $sale = $productOrder->sale;

            if (!empty($sale->total_amount)) {
                Accounting::refundAccounting($sale, $productOrder->id);
            }

            $sale->update([
                'refund_at' => time()
            ]);

            $productOrder->update([
                'status' => ProductOrder::$canceled
            ]);

            return back();
        }

        abort(404);
    }

    public function invoice($id)
    {
        $this->authorize('admin_store_products_orders_invoice');

        $productOrder = ProductOrder::where('id', $id)->first();

        if (!empty($productOrder) and !empty($productOrder->product)) {
            $data = [
                'pageTitle' => trans('webinars.invoice_page_title'),
                'order' => $productOrder,
                'product' => $productOrder->product,
                'sale' => $productOrder->sale,
                'seller' => $productOrder->seller,
                'buyer' => $productOrder->buyer,
            ];

            return view('design_1.panel.store.invoice.index', $data);
        }

        abort(404);
    }

    public function exportExcel(Request $request)
    {
        $this->authorize('admin_store_products_orders_export');

        $query = ProductOrder::where('status', '!=', ProductOrder::$pending)
            ->whereNotNull('sale_id');

        if (!empty($request->get('in-house-orders'))) {
            $adminRoleIds = Role::where('is_admin', true)->pluck('id')->toArray();

            $query->whereHas('seller', function ($query) use ($adminRoleIds) {
                $query->whereIn('role_id', $adminRoleIds);
            });
        }

        $query = $this->getFilters($query, $request);

        $orders = $query->with([
            'product',
            'seller' => function ($query) {
                $query->select('id', 'full_name');
            },
            'buyer' => function ($query) {
                $query->select('id', 'full_name');
            },
            'sale',
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        $export = new StoreOrdersExport($orders);

        return Excel::download($export, 'storeOrders.xlsx');
    }

    public function getProductOrder($saleId, $orderId)
    {
        $this->authorize('admin_store_products_orders_tracking_code');

        $order = ProductOrder::where('id', $orderId)
            ->where('sale_id', $saleId)
            ->first();

        if (!empty($order)) {
            $buyer = $order->buyer;
            $order->address = $buyer->getAddress(true);

            $html = (string)view()->make("admin.store.orders.modals.enter_tracking_code", [
                'order' => $order,
                'saleId' => $saleId,
            ]);

            return response()->json([
                'code' => 200,
                'html' => $html,
            ]);
        }

        return response()->json([], 422);
    }

    public function setTrackingCode(Request $request, $saleId, $orderId)
    {
        $this->authorize('admin_store_products_orders_tracking_code');

        $data = $request->all();

        $validator = Validator::make($data, [
            'tracking_code' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'code' => 422,
                'errors' => $validator->errors(),
            ], 422);
        }

        $order = ProductOrder::where('id', $orderId)
            ->where('sale_id', $saleId)
            ->first();

        if (!empty($order)) {
            $order->update([
                'tracking_code' => $data['tracking_code'],
                'status' => ProductOrder::$shipped
            ]);

            $product = $order->product;
            $seller = $order->seller;

            $notifyOptions = [
                '[p.title]' => $product->title,
                '[u.name]' => $seller->full_name
            ];
            sendNotification('product_tracking_code', $notifyOptions, $order->buyer_id);
        }

        return response()->json([
            'code' => 200
        ]);
    }

    public function fulfillmentDetails($id)
    {
        $this->authorize('admin_store_products_orders');

        $order = ProductOrder::with([
            'product',
            'buyer',
            'seller',
            'license.activations',
            'downloadLogs.file',
        ])->findOrFail($id);

        return response()->json([
            'code' => 200,
            'order' => [
                'id' => $order->id,
                'status' => $order->status,
                'created_at' => dateTimeFormat($order->created_at, 'j M Y H:i'),
                'product' => [
                    'id' => $order->product ? $order->product->id : null,
                    'title' => $order->product ? $order->product->title : '-',
                    'type' => $order->product ? $order->product->type : 'virtual',
                ],
                'buyer' => [
                    'name' => $order->buyer ? $order->buyer->full_name : '-',
                    'email' => $order->buyer ? $order->buyer->email : '-',
                ],
                'license' => $order->license ? [
                    'id' => $order->license->id,
                    'key' => $order->license->license_key,
                    'status' => $order->license->status,
                    'activation_count' => $order->license->activation_count,
                    'max_activations' => $order->license->max_activations,
                    'expires_at' => $order->license->expires_at ? dateTimeFormat($order->license->expires_at, 'j M Y') : 'Lifetime',
                    'activations' => $order->license->activations,
                ] : null,
                'download_logs' => $order->downloadLogs->map(function ($log) {
                    return [
                        'file_title' => $log->file ? $log->file->title : 'File #' . $log->product_file_id,
                        'ip_address' => $log->ip_address,
                        'downloaded_at' => dateTimeFormat($log->created_at, 'j M Y H:i'),
                    ];
                }),
                'total_downloads' => $order->downloadLogs->count(),
            ]
        ]);
    }

    public function resetDownloads(Request $request, $id)
    {
        $this->authorize('admin_store_products_orders');

        $order = ProductOrder::findOrFail($id);
        \App\Models\ProductDownloadLog::where('product_order_id', $order->id)->delete();

        $toastData = [
            'title' => trans('public.request_success'),
            'msg' => "Riwayat & kuota unduhan untuk order #{$order->id} berhasil direset.",
            'status' => 'success'
        ];

        return back()->with(['toast' => $toastData]);
    }
}
