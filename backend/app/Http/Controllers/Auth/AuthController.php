<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller
{
    // ---------------- Register ----------------
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        Auth::login($user);

        return $this->redirectBasedOnRole($user);
    }

    // ---------------- Login ----------------
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        $request->session()->regenerate();
        $user = Auth::user();

        return $this->redirectBasedOnRole($user);
    }

    // ---------------- Logout ----------------
    public function logout(Request $request)
    {
        // Revoke token if using API auth
        $user = $request->user();
        if ($user && $request->bearerToken()) {
            $user->currentAccessToken()?->delete();
            return response()->json(['success' => true, 'message' => 'Logged out'], 200);
        }

        // Fallback to session logout (web)
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully');
    }

    // ---------------- API Session Login (for SPA) ----------------
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Optional: also issue a short-lived JWT for clients that prefer JWT
        $jwt = null;
        $jwtKey = config('app.key');
        if (!empty($jwtKey)) {
            $payload = [
                'sub' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'iat' => time(),
                'exp' => time() + (60 * 60),
            ];
            // app.key may be prefixed with base64: in Laravel
            $secret = str_starts_with($jwtKey, 'base64:') ? base64_decode(substr($jwtKey, 7)) : $jwtKey;
            $jwt = JWT::encode($payload, $secret, 'HS256');
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'jwt' => $jwt,
        ], 200);
    }

    // ---------------- Redirect Based on Role ----------------
    private function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome Admin '.$user->name);
        }

        $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');
        // Create an API token so the SPA can persist it in localStorage
        $token = $user->createToken('auth_token')->plainTextToken;
        // Send user to SPA callback with token as query param
        $callback = rtrim($frontendUrl, '/').'/auth/callback?token='.urlencode($token);
        return redirect()->away($callback)
            ->with('success', 'Welcome '.$user->name);
    }

    // ---------------- Forgot Password Form ----------------
    public function showForgotPasswordForm()
    {
        return view('auth.login', ['forgotPassword' => true]);
    }
   public function showChangePasswordForm()
    {
        return view('auth.change-password'); // create this Blade file
    }

    // ---------------- Handle Change Password ----------------
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password changed successfully. Please login again.');
    }

    // ---------------- API Change Password (Sanctum) ----------------
    public function changePasswordApi(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        /** @var User $user */
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect.'], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully.'], 200);
    }


    // ---------------- Direct Password Update ----------------
    public function resetPasswordDirect(Request $request)
    {
        $request->validate([
            'email'                 => 'required|email|exists:users,email',
            'current_password'      => 'required|string',
            'new_password'          => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Invalid current password or email.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password updated successfully! Please login with new password.');
    }
}

    // ---------------- Show Change Password Form ----------------
  