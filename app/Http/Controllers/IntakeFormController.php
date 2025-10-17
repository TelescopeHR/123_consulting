<?php

namespace App\Http\Controllers;

use App\Models\IntakeForm;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\View;


class IntakeFormController extends Controller
{
    public function __construct()
	{
		View::share('module','Intake Form');
	}
    public function index()
    {
        return view('admin.intakeform.index');
    }

   public function ajax(Request $request)
{
    if ($request->ajax()) {
        $data = IntakeForm::select([
            'id',
            'agency_name',
            'address',
            'dba',
            'phone',
            'email',
            'created_at'
        ]);

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return '<a href="' . route('intakeform.show', $row->id) . '" 
                           class="btn btn-sm btn text-primary"><i class="fa fa-eye"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}

public function show($id)
{
    $intakeForm = IntakeForm::findOrFail($id);
    return view('admin.intakeform.show', compact('intakeForm'));
}


}
