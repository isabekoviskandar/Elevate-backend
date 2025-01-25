<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
        
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            
            if ($user->role->name === 'admin') {
                $request->session()->regenerate();
                return response()->json([
                    'message' => 'Admin login successful', 
                    'user' => $user,
                    'role' => 'admin'
                ]);
            } elseif ($user->role->name === 'user') {
                $request->session()->regenerate();
                return response()->json([
                    'message' => 'User login successful', 
                    'user' => $user,
                    'role' => 'user'
                ]);
            } else {
                auth()->logout();
                return response()->json(['message' => 'Unauthorized access'], 403);
            }
        }
    
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $userRole = Role::where('name', 'user')->first();
    
        if (!$userRole) {
            return response()->json(['message' => 'Default user role not found'], 500);
        }
    
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $userRole->id, 
            ]);
    
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return response()->json(['message' => 'Logged out successfully']);
    }
}
