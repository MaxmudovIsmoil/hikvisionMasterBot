<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryInstallRequest;
use App\Services\CategoryInstallService;
use Illuminate\Http\JsonResponse;

class CategoryInstallController extends Controller
{
    public function __construct(
        private CategoryInstallService $service
    ) {}

    public function index()
    {
        return view('categoryInstall.index');
    }


    public function all()
    {
        return $this->service->all();
    }

    public function getOne(int $id): object
    {
        try {
            return response()->success($this->service->one($id));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function store(CategoryInstallRequest $request): JsonResponse
    {
//        return response()->json($request->validated());
        try {
            $user = $this->service->store($request->validated());
            return response()->success($user);
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function update(CategoryInstallRequest $request, int $id): JsonResponse
    {
        try {
            $result = $this->service->update($request->validated(), $id);
            return response()->success($result);
        }
        catch(\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            return response()->success($this->service->destroy($id));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

}
