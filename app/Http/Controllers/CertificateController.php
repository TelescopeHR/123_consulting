<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Http\Requests\CertificateRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\GenerateCertificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
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
    public function index()
    {
        $certificate = Certificate::all();
        return view('admin.certificate.index', compact('certificate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.certificate.create');
    }

    public function ajax()
    {
        return Datatables::of(Certificate::latest())
            ->addIndexColumn()
            ->editColumn('image_div', function ($row) {
                $btn = '<a href="' . $row->full_image . '" target="_blank">';
                $btn .= '<img src="' . $row->full_image . '" class="img-thumbnail" width="150" >';
                $btn .= '</a>';
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn = '<div style="display: flex;">';
                $btn .= '<a href="' . route('certificate.edit', $row->id) . '" class="btn text-primary">';
                $btn .= '<i class="fa fa-edit"></i>';
                $btn .= '</a>';
                $btn .= '<a href="javascript:void(0)" class="btn text-danger delete" data-id="' . $row->id . '" target-url="' . route('certificate.destroy', ['certificate' => $row->id]) . '">';
                $btn .= '<i class="fa fa-trash"></i>';
                $btn .= '</a>';

                if ($row->preview_pdf) {
                    $btn .= '<a href="' . asset('/pdfs/certificates/' . $row->preview_pdf) . '" class="btn text-primary certificate-preview" target="_blank">';
                    $btn .= '<i class="fa fa-file-pdf"></i>';
                    $btn .= '</a>';
                }
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action', 'image_div'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CertificateRequest $request)
    {
        $file_name = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('/images/certificate/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $image->move($destinationPath, $file_name);
        }

        $certificate = Certificate::create([
            'title' => $request->title,
            'image' => $file_name,
            'line1' => $request->line1,
            'line2' => $request->line2,
            'description' => $request->description,
        ]);

        $certificate_preview = $this->generatePdf($certificate, 'John Doe', $request->title, date('F d, Y'));

        Certificate::where('id', $certificate->id)->update([
            'preview_pdf' => $certificate_preview['preview_pdf']
        ]);

        return redirect()->route('certificate.index')->with(['success' => 'Certificate added successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Certificate::find($id);
        return view('admin.certificate.create', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function update(CertificateRequest $request, $id)
    {
        $certificate = Certificate::where('id', $id)->first();
        $file_name = $certificate->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $file_name = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('/images/certificate/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $image->move($destinationPath, $file_name);
        }

        Certificate::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'line1' => $request->line1,
            'line2' => $request->line2,
            'image' => $file_name,
        ]);

        $certificate = Certificate::where('id', $id)->first();
        $certificate_preview = $this->generatePdf($certificate, 'John Doe', $request->title, date('F d, Y'));

        Certificate::where('id', $id)->update([
            'preview_pdf' => $certificate_preview['preview_pdf']
        ]);

        if (file_exists(public_path('/pdfs/certificates/' . $certificate->preview_pdf))) {
            unlink(public_path('/pdfs/certificates/' . $certificate->preview_pdf));
        }

        return redirect()->route('certificate.index')->with(['success' => 'Certificate updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response    
     */
    public function destroy(Certificate $certificate)
    {
        if ($certificate->quizzes->isEmpty()) {
            $certificate->delete();
            Session::put('success', 'Certificate deleted successfully.');
        } else {
            Session::put('error', 'You can\'t delete the certificate, as it is assigned to quizzes!');
        }
        return response()->json(['status' => true]);
    }
}
