<?php

namespace App\Services;

use App\Exceptions\UnauthorizedException;
use App\Models\User;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    use FileTrait;

    public function login(array $data): bool
    {
        $credentials = [
            'username' => strtolower($data['username']),
            'password' => $data['password']
        ];


        if (! Auth::attempt($credentials)) {
            throw new UnauthorizedException(message: trans('admin.Login or password error'), code: 401);
        }

        return true;
    }


    public function logout()
    {
        Auth::logout();
    }

    public function profile(array $data, int $userId)
    {
        $user = User::findOrfail($userId);
        if (isset($data['password'])) {
            $user->fill(['password' => Hash::make($data['password'])]);
        }
        $user->fill([
            'name' => $data['name'],
            'username' => $data['username']
        ]);
        $user->save();
        return $userId;
    }
}
