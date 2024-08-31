<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Jobs\SendEmailVerification;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UserAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
            'remember' => 'boolean'
        ]);

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        if (!Auth::attempt($credentials, $remember)) {
            // Instead of returning a JSON response, return an Inertia response
            return Inertia::render('Auth/UserLogin', [
                'errors' => ['email' => 'Email or password is incorrect']
            ]);
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        // Redirect to a secure page with Inertia after successful login
        return redirect()->route('main-page')->with([
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }

    public function showLoginForm()
    {
        return Inertia::render('Auth/UserLogin');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.login');
    }

    public function getUser(Request $request)
    {
        return new UserResource($request->user());
    }







    // Show the registration form
    public function showRegisterForm()
    {
        return Inertia::render('Auth/UserRegister');
    }

    // Handle registration form submission
    public function register(Request $request)
    {
        Log::info('Registration process started.');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed.', ['errors' => $validator->errors()]);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Log::info('User created.', ['user' => $user]);

        event(new Registered($user));

        Log::info('Email verification sent.');
        dispatch(new SendEmailVerification($user));
        Auth::login($user);

        Log::info('User logged in.');

        return redirect()->route('user.login')->with('status', 'Verification link sent to your email address.');
    }
}
