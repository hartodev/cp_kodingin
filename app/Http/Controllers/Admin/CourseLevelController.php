<?php

namespace App\Http\Controllers\Admin;

// php artisan make:controller Admin/CourseLevelController --resource

use App\Http\Controllers\Controller;
use App\Models\CourseLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseLevelController extends Controller
{
    public function index()
    {
        $levels = CourseLevel::withCount('courses')->get();

        return view('admin.levels.index', compact('levels'));
    }

    public function create()
    {
        return view('admin.levels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:course_levels,name',
        ]);

        CourseLevel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.levels.index')
            ->with('success', 'Level berhasil ditambahkan.');
    }

    // Route: levels/{level}
    public function edit(CourseLevel $level)
    {
        return view('admin.levels.edit', compact('level'));
    }

    public function update(Request $request, CourseLevel $level)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:course_levels,name,' . $level->id,
        ]);

        $level->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.levels.index')
            ->with('success', 'Level berhasil diperbarui.');
    }

    public function destroy(CourseLevel $level)
    {
        $level->delete();

        return redirect()->route('admin.levels.index')
            ->with('success', 'Level berhasil dihapus.');
    }
}