<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstallRequest;
use App\Services\InstallService;
use Illuminate\Http\JsonResponse;

class InstallController extends Controller
{
    public function __construct(
        public InstallService $service,
    ) {}

    public function index()
    {
        $category = $this->service->category();
        $groups = $this->service->groups();
        $allCount = $this->service->install(id: 0)->count();

        return view('install.index',
            compact('category', 'groups', 'allCount')
        );
    }

    public function getInstall(int $id = 0)
    {
        try {
            return $this->service->getInstall($id);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getOne(int $id): object
    {
        try {
            return response()->success($this->service::one($id));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function store(InstallRequest $request): JsonResponse
    {
        return response()->json($request->validated());
        try {
            $user = $this->service->store($request->validated());
            return response()->success($user);
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function update(InstallRequest $request, int $id): JsonResponse
    {
        return response()->json($request->validated());
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
