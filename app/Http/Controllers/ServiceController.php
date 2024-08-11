<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstallRequest;
use App\Http\Requests\ServiceRequest;
use App\Services\ServiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function __construct(
        private ServiceService $service,
    ) {}

    public function index()
    {
        $groups = $this->service->groups();
        $count = $this->service->count();

        return view('service.index',
            compact('groups', 'count')
        );
    }

    public function getServices()
    {
        try {
            return $this->service->getServices();
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
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

    public function store(ServiceRequest $request): JsonResponse
    {
        // return response()->json($request->validated());
        try {
            $user = $this->service->store($request->validated());
            return response()->success($user);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->fail($e->getMessage());
        }
    }

    public function update(ServiceRequest $request, int $id): JsonResponse
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
