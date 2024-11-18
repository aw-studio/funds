<?php

namespace Funds\Foundation\Http\Controllers;

use Funds\Foundation\SettingsService;
use Illuminate\Http\Request;

class SettingsController
{
    public function show(Request $request, SettingsService $settings)
    {
        return view('funds::settings.show', [
            'settings' => $settings->all(),
        ]);
    }

    public function update(Request $request, SettingsService $settings)
    {
        $data = $request->validate([
            'organization_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'terms' => 'nullable|string',
            'privacypolicy' => 'nullable|string',
            'imprint' => 'nullable|string',
        ]);

        if (! $request->hasFile('logo') && $request->input('logo_delete')) {
            $settings->clear('logo');
        }

        foreach ($data as $key => $value) {
            $settings->set($key, $value);
        }

        return redirect()->route('settings.show');
    }
}
