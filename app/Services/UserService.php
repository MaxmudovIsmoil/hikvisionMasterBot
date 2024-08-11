<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Helpers\Helper;
use App\Models\User;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class UserService
{
//    use FileTrait;

    public function __construct(
        private User $model
    ) {}

    public function count()
    {
        return $this->model->where('role', 2)->whereNull('deleted_at')->count();
    }

    public function getUsers()
    {
        $users = $this->model->where('role', 2)
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get();

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('id', '{{$id}}')
            ->editColumn('status', function($user) {
                return ($user->status == 1)
                    ? '<i class="fas fa-solid fa-check text-success"></i>'
                    : '<i class="fas fa-solid fa-times text-danger"></i>';
            })
            ->editColumn('phone', function($user) {
                return Helper::phoneFormat($user->phone);
            })
            ->addColumn('action', function ($user) {
                return '<div class="d-flex justify-content-between">
                            <a class="js_edit_btn mr-3 btn btn-outline-primary btn-sm"
                                data-update_url="'.route('user.update', $user->id).'"
                                data-one_url="'.route('user.getOne', $user->id).'"
                                href="javascript:void(0);" title="Edit">
                                <i class="fas fa-pen mr-50"></i>
                            </a>
                            <a class="js_delete_btn btn btn-outline-danger btn-sm"
                                data-toggle="modal" data-target="#deleteModal"
                                data-name="'.$user->name.'"
                                data-url="'.route('user.destroy', $user->id).'"
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
            'username' => strtolower($data['username']),
            'password' => Hash::make($data['password']),
            'status' => $data['status'],
            'role' => UserRole::user->value,
            'creator_id' => Auth::id(),
            'created_at' => now(),
        ]);

        return true;
    }

    public function update(array $data, int $id): int
    {
        $user = $this->model::findOrfail($id);
        if (isset($data['username'])) {
            $user->fill(['username' => strtolower($data['username'])]);
        }

        if (isset($data['password'])) {
            $user->fill(['password' => Hash::make($data['password'])]);
        }

        $user->fill([
            'job' => $data['job'],
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'status' => $data['status'],
            'updater_id' => Auth::id(),
            'updated_at' => now(),
        ]);
        $user->save();

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
