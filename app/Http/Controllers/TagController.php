<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class TagController extends Controller
{
    public function __construct()
    {
        View::share('module', 'tag');
    }

    public function ajax()
	{
		return Datatables::of(Tag::latest())
			->addIndexColumn()
			->addColumn('action', function ($row) {
                $btn = '<div style="display: flex;">';
				$btn .= '<a href="' . route('tag.edit', $row->id) . '" class="btn text-primary">';
				$btn .= '<i class="fa fa-edit"></i>';
				$btn .= '</a>';
				$btn .= '<a href="javascript:void(0)" class="btn text-danger delete" data-id="' . $row->id . '" target-url="'.route('tag.destroy', ['tag' => $row->id]).'">';
				$btn .= '<i class="fa fa-trash"></i>';
				$btn .= '</a>';
                $btn .= '</div>';
				return $btn;
			})
			->rawColumns(['action'])
			->make(true);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tag.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        Tag::updateOrCreate([
            'name' => $request->name
        ], [
            'description' => $request->description
        ]);

        return redirect()->route('tag.index')->with(['success' => 'Tag added successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Tag::find($id);
        return view('admin.tag.index', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, $id)
    {
        Tag::where('id', $id)->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('tag.index')->with(['success' => 'Tag updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        Session::put('success', 'Tag deleted successfully.');
        return response()->json(['status' => true]);
    }
}
