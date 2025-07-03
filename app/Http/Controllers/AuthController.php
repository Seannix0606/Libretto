<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Registration successful! Please login with your credentials.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * API Login - Handles token-based authentication
     */
    public function apiLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();

        // Check if user has a valid (non-expired) token
        if ($user->hasValidToken()) {
            // Return existing valid token
            $token = $user->tokens()->latest()->first();
            
            return response()->json([
                'success' => true,
                'message' => 'Login successful - existing token is still valid',
                'user' => $user,
                'token' => $token->plainTextToken ?? 'Token retrieved',
                'token_type' => 'Bearer',
                'expires_at' => $token->created_at->addDay()->toISOString(),
                'token_regenerated' => false
            ]);
        } else {
            // Generate new token (this will delete old tokens)
            $tokenResult = $user->generateNewToken();
            
            return response()->json([
                'success' => true,
                'message' => 'Login successful - new token generated',
                'user' => $user,
                'token' => $tokenResult->plainTextToken,
                'token_type' => 'Bearer',
                'expires_at' => now()->addDay()->toISOString(),
                'token_regenerated' => true
            ]);
        }
    }

    /**
     * API Register
     */
    public function apiRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate token for new user
        $tokenResult = $user->generateNewToken();

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'user' => $user,
            'token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => now()->addDay()->toISOString()
        ], 201);
    }

    /**
     * API Logout - Revoke current token
     */
    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Refresh Token - Generate new token if current one is expired
     */
    public function refreshToken(Request $request)
    {
        $user = $request->user();

        if ($user->hasValidToken()) {
            return response()->json([
                'success' => true,
                'message' => 'Current token is still valid',
                'token_regenerated' => false,
                'expires_at' => $user->tokens()->latest()->first()->created_at->addDay()->toISOString()
            ]);
        }

        // Generate new token
        $tokenResult = $user->generateNewToken();

        return response()->json([
            'success' => true,
            'message' => 'Token refreshed successfully',
            'token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => now()->addDay()->toISOString(),
            'token_regenerated' => true
        ]);
    }
}
