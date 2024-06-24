<?php

namespace App\Services\Admin;

use App\Models\Group;
use App\Models\GroupDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Opcodes\LogViewer\Logs\Log;
use Yajra\DataTables\Facades\DataTables;

class GroupService
{
    public function __construct(
        public Group $group,
        public GroupDetail $detail,
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
            ->editColumn('status', function($group) {
                return $group['status']
                    ? '<div class="text-center"><i class="fas fa-check text-success"></i></div>'
                    : '<div class="text-center"><i class="fas fa-times text-danger"></i></div>';
            })
            ->addColumn('action', function ($group) {
                return '<div class="d-flex justify-content-around">
                            <a class="js_edit_btn mr-3 btn btn-outline-info btn-sm"
                                data-one_url="'.route('group.getOne', $group['id']).'"
                                href="javascript:void(0);" title="Eye">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a class="js_edit_btn mr-3 btn btn-outline-primary btn-sm"
                                data-update_url="'.route('group.update', $group['id']).'"
                                data-one_url="'.route('group.getOne', $group['id']).'"
                                href="javascript:void(0);" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a class="js_delete_btn btn btn-outline-danger btn-sm"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-name="'.$group['name'].'"
                                data-url="'.route('group.destroy', $group['id']).'"
                                href="javascript:void(0);" title="Delete">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </div>';
            })
            ->setRowClass('js_this_tr')
            ->rawColumns(['status', 'action', 'user'])
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make();
    }

    public function one(int $id): array
    {
        return $this->group->findOrFail($id)->with('detail')->toArray();
    }

    public function store(array $data): bool
    {
        DB::beginTransaction();
            $groupId = $this->group::insertGetId([
                'name' => $data['name'],
                'ball' => $data['ball'],
                'level' => $data['level'],
                'status' => $data['status']
            ]);

            for ($i = 0; $i < count($data['key']); $i++) {
                $this->detail::create([
                    'group_id' => $groupId,
                    'key' => $data['key'][$i],
                    'va' => $data['val'][$i],
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
                'ball' => $data['ball'],
                'level' => $data['level'],
                'status' => $data['status']
            ]);
            $group->save();

            $this->detail::where('group_id', $id)->delete();
            for ($i = 0; $i <= count($data['key']); $i++) {
                $this->detail::create([
                    'group_id' => $id,
                    'key' => $data['key'][$i],
                    'va' => $data['va'][$i],
                    'creator_id' => Auth::id(),
                    'updater_id' => Auth::id(),
                ]);
            }
        DB::commit();
        return $id;
    }

    public function destroy(int $id): int
    {
        DB::beginTransaction();
            $this->group::where('id', $id)->update('is_deleted', 1);
            $this->detail::where('group_id', $id)->update('is_deleted', 1);
        DB::commit();
        return $id;
    }

}
