<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppSettingsController extends Controller
{
    //
    public function appSettings()
    {
        $settings = AppSettings::where('site_name','dproperty')->first();
        return view('admin.settings.list',compact('settings'));
    }

    public function updateAppSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_email' => 'required|email|max:255',
            'site_phone' => 'required|string|max:20',
            'site_address' => 'required|string|max:255',
            'site_google_map' => 'nullable|string|max:500',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_description' => 'nullable|string|max:500',
            'facebook_link' => 'nullable|url|max:255',
            'youtube_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // store logo and favicon if provided
            if ($request->hasFile('site_logo')) {
                $logoPath = $request->file('site_logo')->store('logos', 'public');
                // Save $logoPath to your settings storage
            }
            if ($request->hasFile('favicon')) {
                $faviconPath = $request->file('favicon')->store('favicons', 'public');
                // Save $faviconPath to your settings storage
            }
            // Update settings in the database or config file
            $settings = [
                'email' => $request->input('site_email'),
                'phone' => $request->input('site_phone'),
                'address' => $request->input('site_address'),
                'google_map' => $request->input('site_google_map'),
                'site_description' => $request->input('site_description'),
                'facebook' => $request->input('facebook_link'),
                'youtube' => $request->input('youtube_link'),
                'instagram' => $request->input('instagram_link'),
                'logo' => isset($logoPath) ? $logoPath : null,
                'favicon' => isset($faviconPath) ? $faviconPath : null,
            ];
            // Assuming you have a settings model or a config file to save these settings
            AppSettings::updateOrCreate(['site_name' => 'dproperty'], $settings);
            return redirect()->back()
                ->with('success', 'Settings updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }
}
