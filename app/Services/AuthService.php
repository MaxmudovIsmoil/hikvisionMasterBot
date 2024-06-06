<?php

namespace App\Services;

use App\Dto\AuthDto;
use App\Exceptions\UnauthorizedException;
use App\Models\User;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    use FileTrait;

    public function login(AuthDto $dto): bool
    {
        $credentials = [
            'username' => strtolower($dto->username),
            'password' => $dto->password
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

    public function profile(array $data)
    {
        $userId = Auth::id();
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
