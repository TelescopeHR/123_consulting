<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\PolicyManual;
use App\Models\StripeResponse;
use App\Models\UserCourse;
use App\Models\UserPolicy;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function __construct()
    {
        View::share('module', 'order');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.order.index');
    }

    public function ajax(Request $request)
    {
        $stripeResponse = StripeResponse::with(['user'])->whereHas('user')->where('order_id', '!=', '');
        if (isset($request->limit)) {
            $stripeResponse->limit(5)->where('payment_status', 'paid');
        }
        if (!$request->order) {
            $stripeResponse->latest();
        }
        $stripeResponse = $stripeResponse->withTrashed();

        return Datatables::of($stripeResponse)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('m/d/Y');
            })
            ->addColumn('courses', function ($row) {
                $cart_items = json_decode($row->cart_items, true);
                $courses = '';
                $subscription_course = '';
                $policies = '';

                if (isset($cart_items['courses'])) {
                    foreach ($cart_items['courses'] as $course_id) {
                        $course = Course::where('id', $course_id)->first();
                        if ($course) {
                            if (in_array(1, $course->categories->pluck('id')->toArray())) {
                                $subscription_course .= "Subscription Course: " . $course->title . '<br>';
                            } else {
                                $courses .= "Course: " . $course->title . '<br>';
                            }
                        }
                    }
                } else {
                    $user_courses = UserCourse::where('order_id', $row->id)->whereHas('course')->groupBy('course_id')->get();
                    if ($user_courses) {
                        foreach ($user_courses as $user_course) {
                            $courses .= "Course: " . $user_course->course->title . '<br>';
                        }
                    }

                    $user_subscriptions = UserSubscription::where('order_id', $row->id)->whereHas('course')->groupBy('course_id')->get();
                    if ($user_subscriptions) {
                        foreach ($user_subscriptions as $user_subscription) {
                            $subscription_course .= "Subscription Course: " . $user_subscription->course->title . '<br>';
                        }
                    }
                }

                if (isset($cart_items['policies'])) {
                    foreach ($cart_items['policies'] as $policy_id) {
                        $policy_manual = PolicyManual::where('id', $policy_id)->first();
                        if ($policy_manual) {
                            $policies .= "Policy: " . $policy_manual->title . '<br>';
                        }
                    }
                } else {
                    $user_policies = UserPolicy::where('order_id', $row->id)->whereHas('policy_manual')->groupBy('policy_manual_id')->get();
                    if ($user_policies) {
                        foreach ($user_policies as $user_policy) {
                            $policies .= "Policy: " . $user_policy->policy_manual->title . '<br>';
                        }
                    }
                }

                return $courses . $subscription_course . $policies;
            })
            ->editColumn('payment_status', function ($row) {
                $class = $row->payment_status == 'paid' ? 'badge-success' : 'badge-danger';
                return '<span class="p-2 badge ' . $class . ' ml-auto">' . ucwords($row->payment_status) . '</span>';
            })
            ->editColumn('total_amount', function ($row) {
                return "$" . $row->total_amount;
            })
            ->addColumn('action', function ($row) {
                $btn = '<div style="display: flex;">';
                if ($row->deleted_at == NULL) {
                    $btn .= '<a href="javascript:void(0)" class="btn text-primary show-order" target-url="' . route('order.show', $row->id) . '">';
                    $btn .= '<i class="fa fa-eye"></i>';
                    $btn .= '</a>';
                }

                if ($row->invoice) {
                    $btn .= '<a href="' . asset('/pdfs/order_invoices/' . $row->invoice) . '" target="_blank" class="btn text-primary">';
                    $btn .= '<i class="fa fa-file-pdf"></i>';
                    $btn .= '</a>';
                }
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action', 'courses', 'payment_status'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(StripeResponse $order)
    {
        $courses = UserCourse::where('order_id', $order->id)->whereHas('course')->latest()->get();
        $policies = UserPolicy::where('order_id', $order->id)->whereHas('policy_manual')->latest()->get();
        $subscription_courses = UserSubscription::where('order_id', $order->id)->whereHas('course')->latest()->get();

        $view = view('admin.order.show', compact('order', 'courses', 'policies', 'subscription_courses'))->render();
        return response()->json(['status' => true, 'data' => $view]);
    }
}
