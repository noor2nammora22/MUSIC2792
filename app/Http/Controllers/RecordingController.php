<?php

namespace App\Http\Controllers;

use App\Models\Recording;
use Illuminate\Http\Request;

class RecordingController extends Controller
{
    public function index()
    {
        $recordings = Recording::all();

        return response()->json($recordings);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'user_id' => 'required',
            'recording_path' => 'required',
            'note' => 'nullable',
        ]);

        // Create a new recording
        $recording = Recording::create($validatedData);

        return response()->json($recording, 201);
    }

    public function show($id)
    {
        $recording = Recording::findOrFail($id);

        return response()->json($recording);
    }

    public function update(Request $request, $id)
    {
        // Find the recording
        $recording = Recording::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'user_id' => 'required',
            'recording_path' => 'required',
            'note' => 'nullable',
        ]);

        // Update the recording
        $recording->update($validatedData);

        return response()->json($recording);
    }

    public function destroy($id)
    {
        $recording = Recording::findOrFail($id);

        $recording->delete();

        return response()->json(['message' => 'Recording deleted successfully']);
    }
}