<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class LogController extends Controller
{
    public function index(Request $request)
    {
        return view('log.log');
    }
    public function GetData(Request $request)
    {
        if ($request->ajax()) {
            $data = Log::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->setTransformer(function ($log) {
                    return [
                        'id' => $log->id,
                        'message' => $log->message,
                        'created_by' => $log->user->name,
                        'date' => $log->created_at->format('Y/m/d H:i:s'),
                    ];
                })
                ->make(true);
        }
    }
}
