<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectSettingController extends Controller
{
    public function index()
    {
        $settings = ProjectSetting::first();

        if (!$settings) {
            $settings = new ProjectSetting();
        }

        return view('admin.project-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = ProjectSetting::first();

        $request->validate([
            'project_name' => 'required|string|max:30',
            'project_description' => 'nullable|string|max:150',
            'project_logo' => ($settings && $settings->project_logo ? 'nullable' : 'required') . '|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if (!$settings) {
            $settings = new ProjectSetting();
        }

        $settings->project_name = $request->project_name;
        $settings->project_description = $request->project_description;

        if ($request->hasFile('project_logo')) {

            if ($settings->project_logo &&
                Storage::disk('public')->exists($settings->project_logo)) {
                Storage::disk('public')->delete($settings->project_logo);
            }

            $settings->project_logo = $request->file('project_logo')
                ->store('project-settings', 'public');
        }

        $settings->save();

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Project settings updated successfully.');
    }
}