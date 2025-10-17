<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class SettingController extends Controller
{

    public function __construct()
    {
        View::share('module', 'setting');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.setting.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingRequest $request)
    {
        $settings = $request->except(['_token']);

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $logo = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('/images/settings/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $image->move($destinationPath, $logo);
            $settings['logo'] = $logo;
        }

        if ($request->hasFile('faviconicon')) {
            $image = $request->file('faviconicon');
            $faviconicon = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('/images/settings');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $image->move($destinationPath, $faviconicon);
            $settings['faviconicon'] = $faviconicon;
        }
        if (empty(array_filter($settings))) {
            return redirect()->back()->with(['error' => 'please fill up the information']);
        }

        foreach ($settings as $key => $setting) {
            Setting::updateOrCreate(
                [
                    'name' => $key,
                ],
                [
                    'value' => $setting,
                ]
            );
        }
        return redirect()->back()->with(['success' => 'Settings updated successfully.']);
    }
}
