<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstallRequest;
use App\Models\CategoryInstallation;
use App\Models\Installation;
use Illuminate\Http\JsonResponse;

class InstallController extends Controller
{
    public function __construct(
        public Installation $modal
    ) {}

    public function index(int $id = 0)
    {
        $category = CategoryInstallation::where('status', 1)
            ->whereNull('deleted_at')
            ->get()
            ->toArray();

        $installs = Installation::whereNull('deleted_at')
            ->get()
            ->toArray();

        return view('install.index', compact('category', 'installs'));
    }

    public function getOne(int $id): object
    {
        try {
            return response()->success($this->modal::findOrfail($id));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function store(InstallRequest $request): JsonResponse
    {
//        return response()->json($request->validated());
        try {
            $user = $this->modal->store($request->validated());
            return response()->success($user);
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function update(InstallRequest $request, int $id): JsonResponse
    {
        try {
            $result = $this->modal->update($request->validated(), $id);
            return response()->success($result);
        }
        catch(\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            return response()->success($this->modal->destroy($id));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

}
