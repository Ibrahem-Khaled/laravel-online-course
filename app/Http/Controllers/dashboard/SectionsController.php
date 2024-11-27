<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return view('dashboard.sections.index', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sections|max:255',
            'description' => 'nullable',
        ]);

        Section::create($request->all());
        return redirect()->route('sections.index')->with('success', 'Section created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:sections,name,' . $id . '|max:255',
            'description' => 'nullable',
        ]);

        $section = Section::findOrFail($id);
        $section->update($request->all());
        return redirect()->route('sections.index')->with('success', 'Section updated successfully.');
    }

    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();
        return redirect()->route('sections.index')->with('success', 'Section deleted successfully.');
    }

    public function showUsers($id)
    {
        $section = Section::with('users')->findOrFail($id);
        $students = User::where('role', 'student')->get();
        $teachers = User::where('role', 'teacher')->get();
        return view('dashboard.sections.show', compact('section', 'students', 'teachers'));
    }

    public function addUsers(Request $request, $id)
    {
        $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ]);

        $section = Section::findOrFail($id);
        $section->users()->syncWithoutDetaching($request->users);

        return redirect()->back()->with('success', 'Users added to section successfully.');
    }
}
