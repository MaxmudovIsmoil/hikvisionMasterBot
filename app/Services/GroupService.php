<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\Group;
use App\Models\GroupDetail;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class GroupService
{
    public function __construct(
        protected Group $group,
        protected GroupDetail $detail,
        protected GroupUser $groupUser,
    ) {}

    public function getGroups()
    {
        $groups = $this->group
            ->withCount('user')
            ->get()
            ->toArray();

        return DataTables::of($groups)
            ->addIndexColumn()
            ->editColumn('id', '{{$id}}')
            ->editColumn('phone', function($group) {
                return Helper::phoneFormat($group['phone']);
            })
            ->editColumn('status', function($group) {
                return $group['status']
                    ? '<div class="text-center"><i class="fas fa-check text-success"></i></div>'
                    : '<div class="text-center"><i class="fas fa-times text-danger"></i></div>';
            })
            ->addColumn('action', function ($group) {
                return '<div class="d-flex justify-content-around">
                            <a class="js_edit_btn mr-3 btn btn-outline-primary btn-sm"
                                data-update_url="'.route('group.update', $group['id']).'"
                                data-one_url="'.route('group.getOne', $group['id']).'"
                                href="javascript:void(0);" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a class="js_delete_btn btn btn-outline-danger btn-sm"
                                data-toggle="modal" data-target="#deleteModal"
                                data-name="'.$group['name'].'"
                                data-url="'.route('group.destroy', $group['id']).'"
                                href="javascript:void(0);" title="Delete">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </div>';
            })
            ->setRowClass('js_this_tr')
            ->rawColumns(['phone', 'status', 'action'])
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make();
    }

    public function one(int $id)
    {
        return $this->group::with(['user', 'detail'])->findOrFail($id);
    }

    public function store(array $data): bool
    {
        DB::beginTransaction();
            $groupId = $this->group::insertGetId([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'ball' => $data['ball'],
                'level' => $data['level'],
                'status' => $data['status']
            ]);

            $this->groupUser::create([
                'group_id' => $groupId,
                'user_id' => $data['capitan_id'],
                'capitan' => 1,
            ]);

            for ($u = 0; $u < count($data['user']); $u++) {
                $this->groupUser::create([
                    'group_id' => $groupId,
                    'user_id' => $data['user'][$u],
                ]);
            }

            for ($i = 0; $i < count($data['key']); $i++) {
                $this->detail::create([
                    'group_id' => $groupId,
                    'key' => $data['key'][$i],
                    'val' => $data['val'][$i],
                    'creator_id' => Auth::id(),
                    'updater_id' => Auth::id(),
                ]);
            }
        DB::commit();
        return true;
    }

    public function update(array $data, int $id): int
    {
        DB::beginTransaction();
            $group = $this->group::findOrFail($id);
            $group->fill([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'ball' => $data['ball'],
                'level' => $data['level'],
                'status' => $data['status']
            ]);
            $group->save();

            $this->groupUser::where('group_id', $id)->delete();

            $this->groupUser::create([
                'group_id' => $id,
                'user_id' => $data['capitan_id'],
                'capitan' => 1,
            ]);

            if (!empty($data['user'])) {
                for ($u = 0; $u < count($data['user']); $u++) {
                    $this->groupUser::create([
                        'group_id' => $id,
                        'user_id' => $data['user'][$u],
                    ]);
                }
            }

            $this->detail::where('group_id', $id)->delete();
            if (!empty($data['key'])) {
                for ($i = 0; $i < count($data['key']); $i++) {
                    $this->detail::create([
                        'group_id' => $id,
                        'key' => $data['key'][$i],
                        'val' => $data['val'][$i],
                        'creator_id' => Auth::id(),
                        'updater_id' => Auth::id(),
                    ]);
                }
            }

        DB::commit();
        return $id;
    }

    public function destroy(int $id): int
    {
        DB::beginTransaction();
            $this->group::destroy($id);
            $this->detail::where('group_id', $id)->delete();
        DB::commit();
        return $id;
    }



}
