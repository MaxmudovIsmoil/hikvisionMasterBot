<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\User;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserService
{
    use FileTrait;

    public function __construct(
        public User $model
    ) {}

    public function getUsers()
    {
        $users = $this->model->where('role', 2)
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('id', '{{$id}}')
            ->editColumn('status', function($user) {
                return ($user['status'] == 1)
                    ? '<div class="text-center"><i class="fa-solid fa-check text-success"></i></div>'
                    : '<div class="text-center"><i class="fa-solid fa-times text-danger"></i></div>';
            })
            ->editColumn('phone', function($user) {
                return Helper::phoneFormat($user['phone']);
            })
            ->addColumn('action', function ($user) {
                $deleteBtn = '<a class="js_delete_btn btn btn-outline-danger btn-sm"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-name="'.$user['name'].'"
                                data-url="'.route('user.destroy', $user['id']).'"
                                href="javascript:void(0);" title="Delete">
                                <i class="far fa-trash-alt mr-50"></i>
                            </a>';
                if ($user['id'] == 1)
                    $deleteBtn = '<p class="text-center m-0" style="color: darkred;"><i class="fa-solid fa-lock"></i></p>';

                return '<div class="d-flex justify-content-between">
                            <a class="js_edit_btn mr-3 btn btn-outline-primary btn-sm"
                                data-update_url="'.route('user.update', $user['id']).'"
                                data-one_url="'.route('user.getOne', $user['id']).'"
                                href="javascript:void(0);" title="Edit">
                                <i class="fas fa-pen mr-50"></i>
                            </a>'.$deleteBtn.'</div>';
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
        if ($data['phone']) {
            $photo = $this->fileUpload($data['phone']);
        }
        if ($data['resume']) {
            $resume = $this->fileUpload($data['resume']);
        }
        $this->model::create([
            'name' => $data['name'],
            'photo' => $photo ?? null,
            'address' => $data['address'] ?? null,
            'resume' => $resume ?? null,
            'phone' => $data['photo'],
            'username' => strtolower($data['username']),
            'password' => Hash::make($data['password']) ?? null,
            'status' => $data['status'] ?? 0,
        ]);

        return true;
    }

    public function update(array $data, int $id): int
    {
        $user = $this->model::findOrfail($id);
        if (isset($data['password'])) {
            $user->fill(['password' => Hash::make($data['password'])]);
        }

        if (isset($data['resume'])) {
            $this->fileDelete($user->resume);
            $resume = $this->fileUpload($user->resume);
            $user->fill(['resume' => $resume]);
        }

        if (isset($data['photo'])) {
            $this->fileDelete($user->photo);
            $photo = $this->fileUpload($user->photo);
            $user->fill(['photo' => $photo]);
        }

        $user->fill([
            'name' => $data['name'],
            'address' => $data['address'],
            'phone' => $data['photo'],
            'username' => strtolower($data['username']),
            'status' => $data['status'] ?? 0,
        ]);
        $user->save();

        return $id;
    }

    public function destroy(int $id): int
    {
        User::destroy($id);
        return $id;
    }

}
