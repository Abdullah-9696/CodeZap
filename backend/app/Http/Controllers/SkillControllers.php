<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillControllers extends Controller
{
    // List all skills (JSON for frontend)
public function index(Request $request)
{
    $perPage = $request->get('per_page', 3);
    $skills = Skill::paginate($perPage);
    return response()->json($skills);
}

    // Store new skill
    public function store(Request $request)
    {
        $skill = Skill::create($request->all());
        return response()->json($skill, 201);
    }

    // Show one skill
    public function show($id)
    {
        $skill = Skill::findOrFail($id);
        return response()->json($skill);
    }

    // Update skill
    public function update(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);
        $skill->update($request->all());
        return response()->json($skill, 200);
    }

    // Delete skill
    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();
        return response()->json(null, 204);
    }
}
