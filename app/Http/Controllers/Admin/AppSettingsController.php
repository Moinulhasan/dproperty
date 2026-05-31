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
        $settings = AppSettings::where('site_name', 'dproperty')->first();
        return view('admin.settings.list', compact('settings'));
    }

    public function updateAppSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_email' => 'required|email|max:255',
            'site_phone' => 'required|string|max:20',
            'site_address' => 'required|string|max:255',
            'site_google_map' => 'nullable|string|max:500',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
           'contact_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,svg+xml|max:10240',
            'site_description' => 'nullable|string|max:500',
            'facebook_link' => 'nullable|url|max:255',
            'youtube_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'twitter_link' => 'nullable|url|max:255',
            'linkedin_link' => 'nullable|url|max:255',
            'pinterest_link' => 'nullable|url|max:255',
            'why_us_title' => 'nullable|string|max:255',
            'why_us_tagline' => 'nullable|string|max:1000',
            'why_us_items' => 'nullable|array',
            'why_us_items.*.title' => 'nullable|string|max:255',
            'why_us_items.*.description' => 'nullable|string|max:1000',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Fetch current settings
            $current = AppSettings::where('site_name', 'dproperty')->first();

            if ($request->hasFile('site_logo')) {
                $logoPath = $request->file('site_logo')->store('logos', 'public');
            } else {
                $logoPath = $current ? ltrim(preg_replace('/^.*?logos/', 'logos', $current->logo), '/') : null;
            }

            if ($request->hasFile('favicon')) {
                $faviconPath = $request->file('favicon')->store('favicons', 'public');
            } else {
                $faviconPath = $current ? ltrim(preg_replace('/^.*?favicons/', 'favicons', $current->favicon), '/') : null;
            }

            if ($request->hasFile('og_image')) {
                $ogImagePath = $request->file('og_image')->store('og_images', 'public');
            } else {
                $ogImagePath = $current ? ($current->og_image ?? null) : null;
            }

            if ($request->hasFile('contact_image')) {
                $contactPath = $request->file('contact_image')->store('contact_image', 'public');
            } else {
                $contactPath = $current ? ltrim(preg_replace('/^.*?contact_image/', 'contact_image', $current->contact_image), '/') : null;
            }

            // Why-Choose-Us items arrive as an array of {title, description}
            // rows from the dynamic admin form. Drop any row whose title AND
            // description are both empty (those are placeholders the admin
            // added then didn't fill in). Re-index so the JSON list stays a
            // 0-based array, not an associative map.
            $whyUsItems = collect($request->input('why_us_items', []))
                ->map(fn ($row) => [
                    'title'       => trim((string) ($row['title']       ?? '')),
                    'description' => trim((string) ($row['description'] ?? '')),
                ])
                ->filter(fn ($row) => $row['title'] !== '' || $row['description'] !== '')
                ->values()
                ->all();

            $settings = [
                'email' => $request->input('site_email'),
                'phone' => $request->input('site_phone'),
                'address' => $request->input('site_address'),
                'google_map' => $request->input('site_google_map'),
                'site_description' => $request->input('site_description'),
                'facebook' => $request->input('facebook_link'),
                'youtube' => $request->input('youtube_link'),
                'instagram' => $request->input('instagram_link'),
                'twitter' => $request->input('twitter_link'),
                'linkedin' => $request->input('linkedin_link'),
                'pinterest' => $request->input('pinterest_link'),
                'logo' => $logoPath,
                'favicon' => $faviconPath,
                'og_image' => $ogImagePath,
                'contact_image' => $contactPath,
                'why_us_title' => $request->input('why_us_title'),
                'why_us_tagline' => $request->input('why_us_tagline'),
                'why_us_items' => $whyUsItems,
            ];

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
