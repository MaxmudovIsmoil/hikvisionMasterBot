<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupStoreRequest;
use App\Http\Requests\GroupUpdateRequest;
use App\Models\User;
use App\Services\GroupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct(
        public GroupService $service
    ) {}


    public function index()
    {
        $users = User::select('id', 'name')
            ->where('role', 2)
            ->whereNull('deleted_at')
            ->get()
            ->toArray();

        return view('group.index', compact('users'));
    }


    public function getGroups()
    {
        return $this->service->getGroups();
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

    public function store(GroupStoreRequest $request): JsonResponse
    {
//        return response()->json($request->all());
        try {
            $user = $this->service->store($request->validated());
            return response()->success($user);
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function update(GroupUpdateRequest $request, int $id): JsonResponse
    {
//        return response()->json($request->validated());
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
