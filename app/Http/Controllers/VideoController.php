<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoRequest;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class VideoController extends Controller
{
    public function __construct()
    {
        View::share('module', 'Video');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Video::latest())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div style="display: flex;">';
                    $btn .= '<a href="' . route('video.edit', $row->id) . '" class="btn text-primary">';
                    $btn .= '<i class="fa fa-edit"></i>';
                    $btn .= '</a>';
                    $btn .= '<a href="javascript:void(0)" class="btn text-danger delete" target-url="'.route('video.destroy', $row).'">';
                    $btn .= '<i class="fa fa-trash"></i>';
                    $btn .= '</a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.video.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.video.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoRequest $request)
    {
        Video::create([
            'title' => $request->title,
            'youtube_link' => $request->youtube_link,
            'description' => $request->description
        ]);

        return redirect()->route('video.index')->with(['success' => 'Video added successfully.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        return view('admin.video.create', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(VideoRequest $request, Video $video)
    {
        $video->update([
            'title' => $request->title,
            'youtube_link' => $request->youtube_link,
            'description' => $request->description
        ]);

        return redirect()->route('video.index')->with(['success' => 'Video updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $video->delete();
        session()->flash('success', 'Video deleted successfully.');
        return response()->json(['status' => true]);
    }
}
