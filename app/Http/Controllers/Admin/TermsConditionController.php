<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermsCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TermsConditionController extends Controller
{
    public function index()
    {
        // Keyed by 'buy'/'sell' so the view can do $terms['buy']->content
        // without a null-safe dance.
        $terms = TermsCondition::whereIn('key', ['buy', 'sell'])
            ->get()
            ->keyBy('key');

        return view('admin.terms_conditions.index', compact('terms'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Summernote can produce large HTML — no length cap.
            'buy_terms'  => 'nullable|string',
            'sell_terms' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        TermsCondition::updateOrCreate(
            ['key' => 'buy'],
            ['content' => $request->input('buy_terms')]
        );
        TermsCondition::updateOrCreate(
            ['key' => 'sell'],
            ['content' => $request->input('sell_terms')]
        );

        return redirect()->route('admin.terms-conditions.index')
            ->with('success', 'Terms & Conditions updated successfully.');
    }
}
