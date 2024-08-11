<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class MasterService
{
    public function __construct(
        private User $model
    ) {}

    public function count()
    {
        return $this->model->where('role', 3)->whereNull('deleted_at')->count();
    }

    public function getMasters()
    {
        $masters = $this->model->where('role', 3)
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get();

        return DataTables::of($masters)
            ->addIndexColumn()
            ->editColumn('id', '{{$id}}')
            ->editColumn('status', function($master) {
                return ($master->status == 1) ? '<i class="fas fa-solid fa-check text-success"></i>': '<i class="fas fa-solid fa-times text-danger"></i>';
            })
            ->editColumn('phone', function($master) {
                return Helper::phoneFormat($master->phone);
            })
            ->addColumn('action', function ($master) {
                return '<div class="d-flex justify-content-between">
                            <a class="js_edit_btn mr-3 btn btn-outline-primary btn-sm"
                                data-update_url="'.route('master.update', $master->id).'"
                                data-one_url="'.route('master.getOne', $master->id).'"
                                href="javascript:void(0);" title="Edit">
                                <i class="fas fa-pen mr-50"></i>
                            </a>
                            <a class="js_delete_btn btn btn-outline-danger btn-sm"
                                data-toggle="modal" data-target="#deleteModal"
                                data-name="'.$master->name.'"
                                data-url="'.route('master.destroy', $master->id).'"
                                href="javascript:void(0);" title="Delete">
                                <i class="far fa-trash-alt mr-50"></i>
                            </a>
                        </div>';
            })
            ->setRowClass('js_this_tr')
            ->rawColumns(['status', 'phone', 'action'])
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make();
    }


    public function one(int $id)
    {
        return $this->model::findOrFail($id);
    }

    public function store(array $data): bool
    {
        $this->model::create([
            'job' => $data['job'],
            'name' => $data['name'],
            'address' => $data['address'] ?? null,
            'phone' => $data['phone'],
            'status' => $data['status'],
            'role' => UserRole::master->value,
            'creator_id' => Auth::id(),
            'created_at' => now(),
        ]);

        return true;
    }

    public function update(array $data, int $id): int
    {
        $this->model::where('id', $id)
            ->update([
                'job' => $data['job'],
                'name' => $data['name'],
                'address' => $data['address'],
                'phone' => $data['phone'],
                'status' => $data['status'],
                'updater_id' => Auth::id(),
                'updated_at' => now(),
            ]);

        return $id;
    }

    public function destroy(int $id): int
    {
        User::where('id', $id)->update([
            'deleter_id' => Auth::id(),
            'deleted_at' => now(),
        ]);
//        User::destroy($id);
        return $id;
    }

}
