<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserType;
use App\Events\PasswordResetRequested;
use App\Events\PasswordResetSucceeded;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\PasswordRequest;
use App\PasswordReset;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends APIController
{
    public function login(AuthRequest $request)
    {
        if (Auth::attempt($request->only(['email', 'password'])))
        {
            $token = Auth::user()->createToken('AppName')->accessToken;

            return response()->json(['access_token' => $token]);
        }

        return response()->json(['error' => 'Unauthorised'], 401);
    }

    public function register(AuthRequest $request)
    {
        $data = $request->only(['name', 'email', 'password', 'phone', 'DOB', 'gender']);
        $data['password'] = Hash::make($data['password']);
        $data['type'] = UserType::CLIENT;
        $user = User::create($data);
        $token = $user->createToken('AppName')->accessToken;

        return response()->json(['access_token' => $token], 201);
    }

    public function nullableRegister()
    {
        $data = [];
        $data['name'] = '';
        $data['email'] = '';
        $data['password'] = '';
        $data['phone'] = '';
        $data['gender'] = '';
        $user = User::create($data);
        $token = $user->createToken('AppName')->accessToken;

        return response()->json(['access_token' => $token], 201);
    }

    public function logout()
    {
        $token = Auth::user()->token();
        $token->revoke();

        return response()->json(['success' => 'Logout successfully']);
    }

    public function create(PasswordRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        $passwordReset = PasswordReset::updateOrCreate(['email' => $user->email], [
            'email' => $user->email,
            'token' => rand(1000, 9999)
        ]);

        event(new PasswordResetRequested($user, $passwordReset->token));

        return response()->json(['message' => 'We have e-mailed your password reset link!']);
    }

    public function find(PasswordRequest $request)
    {
        $passwordReset = PasswordReset::where('token', $request->input('token'))->first();

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast())
        {
            $passwordReset->delete();

            return response()->json(['message' => 'This password reset token is invalid.'], 401);
        }

        return response()->json(['user' => $passwordReset]);
    }

    public function reset(PasswordRequest $request)
    {
        $passwordReset = PasswordReset::where([
            ['token', $request->input('token')],
            ['email', $request->input('email')]
        ])->first();

        if (!$passwordReset)
            return response()->json(['message' => 'This password reset token is invalid.'], 401);

        $user = User::where('email', $passwordReset->email)->first();
        $user->password = Hash::make($request->input('password'));
        $user->save();
        $passwordReset->delete();

        event(new PasswordResetSucceeded($user));

        return response()->json($user);
    }
}
