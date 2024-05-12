<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Setting::all();
        return view('dash.setting.all', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dash.setting.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $locales = LaravelLocalization::getSupportedLocales();

        $rules = [
            'logo' => 'required|image',
            'favicon' => 'required',
            'facebook' => 'required|string',
            'linkedin' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
        ];

        foreach($locales  as $localeCode => $properties) {
            $rules["{$localeCode}.title"] = 'required|string';
            $rules["{$localeCode}.content"] = 'required|string';
        }

        $request->validate($rules);

        $allSettingsWithoutImages = $request->except(['logo','favicon']);
        $setting = Setting::create($allSettingsWithoutImages);

        if($request->file('logo')) {
            $uploadedLogo = $setting->addMediaFromRequest('logo')

            ->toMediaCollection('logo');
            $setting->update([
                'logo' => $uploadedLogo->getUrl()
            ]);
        }
        if($request->file('favicon')) {
            $uploadedFavicon = $setting->addMediaFromRequest('favicon')->toMediaCollection('favicon');
            $setting->update([
                'favicon' => $uploadedFavicon->getUrl()
            ]);
        }
        return redirect()->route('dashboard.setting.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        return view('dash.setting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $locales = LaravelLocalization::getSupportedLocales();

        $rules = [
            'logo' => 'image',
            'facebook' => 'required|string',
            'linkedin' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
        ];

        foreach($locales  as $localeCode => $properties) {
            $rules["{$localeCode}.title"] = 'required|string';
            $rules["{$localeCode}.content"] = 'required|string';
        }

        $request->validate($rules);

        $allSettingsWithoutImages = $request->except(['logo','favicon']);
        $setting->update($allSettingsWithoutImages);

        if($request->file('logo')) {
            $oldLogo = $setting->media;
            $oldLogo[0]->delete();
            $uploadedLogo = $setting->addMediaFromRequest('logo')->toMediaCollection('logo');
            $setting->update([
                'logo' => $uploadedLogo->getUrl()
            ]);
        }
        if($request->file('favicon')) {
            $oldFav = $setting->media;
            $oldFav[1]->delete();
            $uploadedFavicon = $setting->addMediaFromRequest('favicon')->toMediaCollection('favicon');
            $setting->update([
                'favicon' => $uploadedFavicon->getUrl()
            ]);
        }
        return redirect()->route('dashboard.setting.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        $setting->clearMediaCollection('logo');
        $setting->clearMediaCollection('favicon');
        $setting->delete();
        return redirect()->route('dashboard.setting.index');
    }
}
