<?php

namespace App\Http\Controllers;

use App\Models\Abandoned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class AbandonedController extends Controller
{
    public function __construct()
    {
        View::share('module', 'Abandoned Cart');
    }

    public function index()
    {
        return view('admin.abandoned.index');
    }

    public function ajax()
    {
        return DataTables::of(Abandoned::whereHas('user')->with(['user', 'course', 'policy'])->whereNotnull('user_id')->latest())
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if ($row->status == 1) {
                    return "Added to cart <strong>" . $row->created_at->diffForHumans() . "</strong>";
                }
                if ($row->status == 2) {
                    return "<span class='text-danger'>Removed from cart <strong>" . $row->created_at->diffForHumans() . "</strong></span>";
                }
                if ($row->status == 3) {
                    return "Go to Checkout <strong>" . $row->created_at->diffForHumans() . "</strong>";
                }
                if ($row->status == 4) {
                    return "<span class='text-success'>Purchased <strong>" . $row->created_at->diffForHumans() . "</strong></span>";
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
