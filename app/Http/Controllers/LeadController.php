<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class LeadController extends Controller
{
    public function __construct()
    {
        View::share('module', 'lead');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $leads = Lead::query();
            if (!$request->order) {
                $leads->latest();
            }
            return DataTables::of($leads)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="btn text-danger delete" target-url="' . route('lead.destroy', $row) . '">';
                    $btn .= '<i class="fa fa-trash"></i>';
                    $btn .= '</a>';
                    $btn .= '</div>';    
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.lead.index');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        Session::put('success', 'Lead deleted successfully.');
        return response()->json(['status' => true]);
    }
}
