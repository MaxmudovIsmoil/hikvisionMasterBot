<?php

namespace App\Http\Controllers;

use App\Exceptions\UnauthorizedException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserProfileRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $service
    ) {}


    /**
     * @param LoginRequest $request
     * @throws UnauthorizedException
     */
    public function login(LoginRequest $request)
    {
        try {
            $this->service->login($request->validated());
            return redirect()->intended('/dashboard');
        }
        catch (UnauthorizedException $e) {
            return Redirect::back()->withErrors([
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    public function logout()
    {
        $this->service->logout();

        return redirect()->route('login');
    }


    public function profile(UserProfileRequest $request, int $id): JsonResponse
    {
        try {
            $result = $this->service->profile($request->validated(), $id);
            return response()->success($result);
        }
        catch(\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }
}
