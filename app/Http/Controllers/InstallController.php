<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstallOrServiceStopRequest;
use App\Http\Requests\InstallRequest;
use App\Services\InstallService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Nutgram\Laravel\Facades\Telegram;
use Opcodes\LogViewer\Logs\Log;

class InstallController extends Controller
{
    public function __construct(
        private InstallService $service,
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
            return response()->success($this->service->one($id));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function store(InstallRequest $request): JsonResponse
    {
//        return response()->json($request->validated());
        try {
            $user = $this->service->store($request->validated());
            return response()->success($user);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->fail($e->getMessage());
        }
    }

    public function update(InstallRequest $request, int $id): JsonResponse
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

    public function stop(InstallOrServiceStopRequest $request, int $id)
    {
        try {
            $res = $this->service->stop($request->validated('comment'), $id);
            return response()->success($res);
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

}
