<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardSettingsProfileController extends Controller
{
    public function edit()
    {
        return inertia('Dashboard/Settings/Profile');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string']
        ]);

        auth()->user()->update([
            'name' => $validated['name']
        ]);

        return back()->with('message', 'You have updated your profile.');
    }
}
