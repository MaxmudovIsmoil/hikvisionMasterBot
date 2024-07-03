<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\CategoryInstallation;
use App\Models\Group;
use App\Models\GroupDetail;
use App\Models\GroupUser;
use App\Models\Installation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class InstallService
{
    public function __construct(
        public CategoryInstallation $category,
        public Installation $install,
    ) {}

    public function category(): array
    {
        return CategoryInstallation::where('status', 1)
            ->whereNull('deleted_at')
            ->get()
            ->toArray();
    }

    public function getInstall(int $id)
    {
        $install = $this->install::whereNull('deleted_at')
                ->when($id !== 0, function($query) use ($id) {
                    $query->where('category_id', $id);
                })
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();

        return DataTables::of($install)
            ->addIndexColumn()
            ->editColumn('id', '{{$id}}')
            ->editColumn('phone', function($install) {
                return Helper::phoneFormat($install->phone);
            })
//            ->editColumn('status', function($install) {
//                return $install->status->getLabelText();
//            })
            ->addColumn('action', function ($install) {
                return '<div class="d-flex justify-content-around">
                            <a class="js_edit_btn mr-3 btn btn-outline-primary btn-sm"
                                data-update_url="'.route('install.update', $install->id).'"
                                data-one_url="'.route('install.getOne', $install->id).'"
                                href="javascript:void(0);" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a class="js_delete_btn btn btn-outline-danger btn-sm"
                                data-toggle="modal" data-target="#deleteModal"
                                data-name="'.$install->blanka_number.'"
                                data-url="'.route('install.destroy', $install->id).'"
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
        return $this->install::with(['category'])->findOrFail($id);
    }

    public function store(array $data): bool
    {
        DB::beginTransaction();
            $installId = $this->group::insertGetId([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'ball' => $data['ball'],
                'level' => $data['level'],
                'status' => $data['status']
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
