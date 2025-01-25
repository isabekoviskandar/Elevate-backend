<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function index()
    {
        try {
            $projects = Project::all();
            return ProjectResource::collection($projects);
        } catch (\Exception $e) {
            Log::error('Error fetching projects: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch projects'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'category_id' => 'required',
                'title' => 'required',
                'description' => 'required',
                'text' => 'required',
                'image1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
                'image2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
                'image3' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
                'image4' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
                'image5' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
                'video' => 'required|file|mimes:mp4,webm,ogg|max:10048',
                'goal' => 'required|integer',
                'date' => 'required',
            ]);

            $project = Project::create([
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'text' => $request->text,
                'image1' => $request->file('image1')->store('images'),
                'image2' => $request->file('image2')->store('images'),
                'image3' => $request->file('image3')->store('images'),
                'image4' => $request->file('image4')->store('images'),
                'image5' => $request->file('image5')->store('images'),
                'video' => $request->file('video')->store('videos'),
                'goal' => $request->goal,
                'date' => $request->date,
            ]);

            return new ProjectResource($project);

        } catch (\Exception $e) {
            Log::error('Error creating project: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create project'], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:projects,id',
                'user_id' => 'required',
                'category_id' => 'required',
                'title' => 'required',
                'description' => 'required',
                'text' => 'required',
                'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
                'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
                'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
                'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
                'image5' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
                'video' => 'nullable|file|mimes:mp4,webm,ogg|max:10048',
                'goal' => 'required|integer',
                'date' => 'required',
            ]);

            $project = Project::findOrFail($request->id);
            $project->update([
                'user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'text' => $request->text,
                'image1' => $request->hasFile('image1') ? $request->file('image1')->store('images') : $project->image1,
                'image2' => $request->hasFile('image2') ? $request->file('image2')->store('images') : $project->image2,
                'image3' => $request->hasFile('image3') ? $request->file('image3')->store('images') : $project->image3,
                'image4' => $request->hasFile('image4') ? $request->file('image4')->store('images') : $project->image4,
                'image5' => $request->hasFile('image5') ? $request->file('image5')->store('images') : $project->image5,
                'video' => $request->hasFile('video') ? $request->file('video')->store('videos') : $project->video,
                'goal' => $request->goal,
                'date' => $request->date,
            ]);

            return new ProjectResource($project);

        } catch (\Exception $e) {
            Log::error('Error updating project: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update project'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);
            $project->delete();

            return response()->json(['message' => 'Project deleted successfully']);

        } catch (\Exception $e) {
            Log::error('Error deleting project: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete project'], 500);
        }
    }
}
