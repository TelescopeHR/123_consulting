<?php

namespace App\Http\Controllers;

use App\Models\UserCourse;
use App\Traits\GenerateCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class UserCertificateController extends Controller
{
    use GenerateCertificate;

    public function __construct()
    {
        View::share('module', 'certificate');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $userCourses = UserCourse::with(['user', 'course'])
                ->where('certificate', '!=', NULL)
                ->whereHas('user')
                ->whereHas('course');

            if (!$request->order) {
                $userCourses = $userCourses->latest();
            }

            return DataTables::of($userCourses)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div style="display: flex;">';
                    $btn .= '<a href="' . asset('/pdfs/certificates/' . $row->certificate) . '" class="btn text-primary certificate-preview" target="_blank">';
                    $btn .= '<i class="fa fa-file-pdf"></i>';
                    $btn .= '</a>';
                    // edit certificate name open modal
                    $btn .= '<a href="javascript:void(0)" class="btn text-primary edit-certificate-name" data-id="' . $row->id . '" data-certificate_name="' . $row->certificate_name . '">';
                    $btn .= '<i class="fa fa-edit"></i>';
                    $btn .= '</a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.user-certificate.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'certificate_name' => 'required|string|max:255',
        ]);

        $user_course = UserCourse::find($id);

        // generate certificate
        $caregiver_name = $user_course->certificate_name ?? ($user_course->caregiver->first_name . ' ' . $user_course->caregiver->last_name);
        $certificate_file = $this->generatePdf($user_course->course->quizzes->first()->certificate, $caregiver_name, $user_course->course->title, $user_course->end_date->format('F d, Y'));

        $user_course->certificate_name = $request->certificate_name;
        $user_course->certificate = $certificate_file['preview_pdf'];
        $user_course->save();


        return response()->json(['success' => true, 'message' => 'Certificate name updated successfully.']);
    }   
}
