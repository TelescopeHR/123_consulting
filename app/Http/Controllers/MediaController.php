<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaRequest;
use App\Models\Media;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class MediaController extends Controller
{
    public function ajax()
    {
        return Datatables::of(Media::latest())
            ->addIndexColumn()
            ->editColumn('image_div', function ($row) {
                $ext = pathinfo($row->file_url, PATHINFO_EXTENSION);
                $imgExts = array("gif", "jpg", "jpeg", "png", "tiff", "tif");
                if (in_array($ext, $imgExts)) {
                    $btn = '<a href="' . $row->file_url . '">';
                    $btn .= '<img src="' . $row->file_url . '" class="img-thumbnail" width="150">';
                    $btn .= '</a>';
                } else {
                    $btn = '<a href="' . $row->file_url . '" target="_blank">View File</a>';
                }
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn = '<div style="display: flex;">';                
                $btn .= '<a href="javascript:void(0)" class="btn text-primary" title="Copy URL" onClick="copyToClipboard(\'' . $row->file_url . '\')">';
                $btn .= '<i class="fa fa-copy"></i>';
                $btn .= '</a>';
                $btn .= '<a href="javascript:void(0)" class="btn text-danger delete" data-id="' . $row->id . '" target-url="'.route('media.delete', ['media' => $row->id]).'">';
                $btn .= '<i class="fa fa-trash"></i>';
                $btn .= '</a>';
                $btn .= '</div>';    
                return $btn;
            })
            ->rawColumns(['action', 'image_div', 'full_url'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.media.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MediaRequest $request)
    {
        $file_name = '';
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $file_name = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('/media-files');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $image->move($destinationPath, $file_name);
        }

        $short_code = $this->random_strings(6);
        Media::create([
            'file' => $file_name,
            'short_code' => "[media-id=" . $short_code . "]"
        ]);

        return response()->json(['status' => true, 'message' => 'Media uploaded successfully.']);
    }

    function random_strings($length_of_string)
    {
        // String of all alphanumeric character
        $str_result = '0123456789abcdefghijklmnopqrstuvwxyz';

        // Shuffle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        $media->delete();
        Session::put('success', 'Media deleted successfully.');
        return response()->json(['status' => true, 'message' => 'Media uploaded successfully.']);
    }
}
