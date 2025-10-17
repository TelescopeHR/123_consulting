<?php

namespace App\Http\Controllers;

use App\Models\UserPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;


class UserPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {
            $user_id = $user->hasRole(Config::get('constants.users_roles.caregiver')) ? $user->parent_id : $user->id;
            $user_policies = UserPolicy::with(['policy_manual'])->where('user_id', $user_id)->whereHas('policy_manual')->latest()->get();

            return Datatables::of($user_policies)
                ->addIndexColumn()
                ->addColumn('purchase_date', function ($row) {
                    return \Carbon\Carbon::parse($row->purchase_date)->format('m/d/Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div style="display: flex;">';
                    $btn .= '<a href="' . asset('/policy-manual/' . $row->policy_manual->document) . '" target="_blank">';
                    $btn .= '<i class="fa fa-file-image" aria-hidden="true"></i>';
                    $btn .= '</a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.user.policies.index');
    }
}
