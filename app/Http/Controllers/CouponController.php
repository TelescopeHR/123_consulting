<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{

	public function __construct()
	{
		View::share('module', 'coupon');
	}

	public function index()
	{
		return view('admin.coupon.index');
	}

	/**
	 * @param Request $request
	 */
	public function ajax(Request $request)
	{
		if ($request->ajax()) {
			$data = Coupon::latest()->get();

			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('expired_at', function ($row) {
					return $row->expired_at ? $row->expired_at->format('m/d/Y') : '-';
				})
				->addColumn('value', function ($row) {
					if ($row->type == 'percentage') {
						return $row->value . '%';
					} else {
						return  '$' . $row->value;
					}
				})

				->addColumn('action', function ($row) {
					$btn = '<div style="display: flex;">';
					$btn .= '<a href="' . route('coupon.edit', $row->id) . '" class="btn text-primary">';
					$btn .= '<i class="fa fa-edit"></i>';
					$btn .= '</a>';
					if ($row->id != 1) {
						$btn .= '<a href="javascript:void(0)" class="btn text-danger delete" data-id="' . $row->id . '" target-url="' . route('coupon.destroy', ['coupon' => $row->id]) . '">';
						$btn .= '<i class="fa fa-trash"></i>';
						$btn .= '</a>';
					}
					$btn .= '</div>';	

					return $btn;
				})
				->rawColumns(['expired_at', 'action'])
				->make(true);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.coupon.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CouponRequest $request)
	{
		Coupon::create([
			'code' => $request->code,
			'type' => $request->type,
			'value' => number_format($request->value, 2),
			'expired_at' => $request->expired_at ? Carbon::createFromFormat('m/d/Y', $request->expired_at)->format('Y-m-d') : NULL
		]);

		return redirect()->route('coupon.index')->with(['success' => 'Coupon added successfully.']);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Coupon  $coupon
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Coupon $coupon)
	{
		$data = $coupon;
		return view('admin.coupon.create', compact('data'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Coupon  $coupon
	 * @return \Illuminate\Http\Response
	 */
	public function update(CouponRequest $request, Coupon $coupon)
	{
		$coupon->code = $request->code;
		$coupon->type = $request->type;
		$coupon->value = number_format($request->value, 2);
		$coupon->expired_at = $request->expired_at ? Carbon::createFromFormat('m/d/Y', $request->expired_at)->format('Y-m-d') : NULL;
		$coupon->save();

		return redirect()->route('coupon.index')->with(['success' => 'Coupon updated successfully.']);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Coupon  $coupon
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Coupon $coupon)
	{
		if ($coupon->id != 1) {
			$coupon->delete();
			Session::put('success', 'Coupon deleted successfully.');
		} else {
			Session::put('error', 'You can\'t delete this coupon.');
		}
		return response()->json(['status' => true]);
	}
}
