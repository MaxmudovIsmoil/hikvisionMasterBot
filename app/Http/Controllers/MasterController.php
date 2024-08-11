<?php

namespace App\Http\Controllers;

use App\Http\Requests\MasterStoreRequest;
use App\Http\Requests\MasterUpdateRequest;
use App\Http\Requests\MaterStoreRequest;
use App\Http\Requests\MaterUpdateRequest;
use App\Services\MasterService;
use App\Services\MaterService;
use Illuminate\Http\JsonResponse;


class MasterController extends Controller
{
    public function __construct(
        private MasterService $service
    ) {}

    public function index()
    {
        $count = $this->service->count();

        return view('master.index', compact('count'));
    }

    public function getMasters()
    {
        return $this->service->getMasters();
    }

    public function getOne(int $id)
    {
        try {
            return response()->success($this->service->one($id));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function store(MasterStoreRequest $request)
    {
//        return response()->json(['res' =>$request->all()]);
        try {
            $user = $this->service->store($request->validated());
            return response()->success($user);
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function update(MasterUpdateRequest $request, int $id): JsonResponse
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
