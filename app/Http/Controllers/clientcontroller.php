<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class clientcontroller extends Controller
{

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json([
            'user' => $user,
            'access_token' => $accessToken,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $accessToken = $user->createToken('authToken')->accessToken;

            return response()->json([
                'user' => $user,
                'access_token' => $accessToken,
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        // Create a new user
        $user = User::create($validatedData);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        // Find the user
        $user = User::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required|min:8',
        ]);

        // Update the user
        $user->update($validatedData);

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
