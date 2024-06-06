<?php

namespace App\Services;

use App\Models\Instance;
use App\Models\UserInstance;
use App\Models\UserPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserPlanService
{
    public function instances(int $userInstanceId)
    {
        return Instance::select('id', 'name_ru')
            ->where('id', '<>', $userInstanceId)
            ->where(['status' => 1])
            ->get();
    }

    public function userInstances()
    {
        return UserInstance::where('user_id', Auth::id())
            ->with(['instance', 'user_plan', 'user_plan.another_instance'])
            ->get();
    }

    public function getInstance(int $id)
    {
        return Instance::select('id', 'name_ru')->findOrFail($id);
    }

    public function create(array $data)
    {
        return UserPlan::create([
            'user_id' => Auth::id(),
            'user_instance_id' => $data['user_instance_id'],
            'instance_id' => $data['instance_id'],
            'stage' => ($data['stage']*1 + 1),
        ]);
    }

    public function update(array $data, int $id)
    {
        UserPlan::findOrfail($id)->update(['instance_id' => $data['instance_id']]);
        return $id;
    }

    public function delete(int $id)
    {
        DB::beginTransaction();
            $userPlan = UserPlan::findOrFail($id);
            $userPlanBig = UserPlan::where('stage', '>', $userPlan->stage)->get();
            $userPlan->delete();

            UserPlan::whereIn('id', $userPlanBig->pluck('id'))->decrement('stage');
        DB::commit();
        return $id;
    }

}
