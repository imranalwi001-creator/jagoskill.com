<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AgoraHistoryExport;
use App\Http\Controllers\Controller;
use App\Models\AgoraHistory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AgoraHistoryController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('admin_agora_history_list');

        $query = AgoraHistory::whereNotNull('end_at');

        $agoraHistories = $this->handleFilters($request, $query)
            ->with([
                'session' => function ($query) {
                    $query->with('webinar');
                }
            ])
            ->paginate(10);

        $data = [
            'pageTitle' => trans('update.agora_history'),
            'agoraHistories' => $agoraHistories
        ];

        return view('admin.agora_history.index', $data);
    }

    private function handleFilters(Request $request, $query)
    {
        $search = $request->get('search');
        $from = $request->get('from');
        $to = $request->get('to');
        $sort = $request->get('sort');

        $query = fromAndToDateFilter($from, $to, $query, 'start_at');

        if (!empty($search)) {
            $query->whereHas('session', function ($query) use ($search) {
                $query->whereTranslationLike('title', "%{$search}%")
                    ->orWhereHas('webinar', function ($query) use ($search) {
                        $query->whereTranslationLike('title', "%{$search}%");
                    });
            });
        }

        switch ($sort) {
            case 'session_start_date_asc':
                $query->orderBy('start_at', 'asc');
                break;
            case 'session_start_date_desc':
            default:
                $query->orderBy('start_at', 'desc');
                break;
        }

        return $query;
    }

    public function exportExcel(Request $request)
    {
        $this->authorize('admin_agora_history_list');

        $query = AgoraHistory::whereNotNull('end_at');

        $agoraHistories = $this->handleFilters($request, $query)
            ->with([
                'session' => function ($query) {
                    $query->with('webinar');
                }
            ])
            ->get();

        $export = new AgoraHistoryExport($agoraHistories);

        return Excel::download($export, 'agoraHistory.xlsx');
    }
}
