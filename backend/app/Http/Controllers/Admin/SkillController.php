<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
    public function index(Request $request)
    {
        $skills = Skill::paginate(3); // 3 skills per page

        if ($request->ajax()) {
            return response()->json($skills); // For lazy loading
        }

        return view('admin.skills.index', compact('skills'));
    }



    // Show form to create a new skill
    public function create()
    {
        return view('admin.skills.create');
    }

    // Store a new skill
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'nullable|url',
            'linkText' => 'nullable|string'
        ]);

        $data = $request->all();
        // agar linkText empty ho to default set karo
        $data['linkText'] = $request->input('linkText') ?: 'View';

        Skill::create($data);

        return redirect()->route('admin.skills.index')
                         ->with('success', 'Skill added successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $skill = Skill::findOrFail($id);
        return view('admin.skills.edit', compact('skill'));
    }

    // Update a skill
    public function update(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'link' => 'nullable|url',
            'linkText' => 'nullable|string'
        ]);

        $data = $request->all();
        // agar linkText empty ho to default set karo
        $data['linkText'] = $request->input('linkText') ?: 'View';

        $skill->update($data);

        return redirect()->route('admin.skills.index')
                         ->with('success', 'Skill updated successfully!');
    }

    // Delete a skill
    public function destroy($id)
    {
        Skill::destroy($id);
        return redirect()->route('admin.skills.index')
                         ->with('success', 'Skill deleted successfully!');
    }
}
