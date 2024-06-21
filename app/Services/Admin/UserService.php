<?php

namespace App\Services\Admin;

use App\Jobs\SendEmailAdminUpdateJob;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\DataTables;

class UserService
{
    public function __construct(
        public User $model
    ) {}

    public function getUsers()
    {
        $users = $this->model->where('is_deleted',0)
            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('id', '{{$id}}')
            ->editColumn('status', function($user) {
                return ($user['status'] == 1)
                    ? '<div class="text-center"><i class="fa-solid fa-check text-success"></i></div>'
                    : '<div class="text-center"><i class="fa-solid fa-xmark text-danger"></i></div>';
            })
            ->editColumn('ldap', function($user) {
                return ($user['ldap'] == 1)
                    ? '<div class="text-center"><i class="fa-solid fa-check text-success"></i></div>'
                    : '<div class="text-center"><i class="fa-solid fa-xmark text-danger"></i></div>';
            })
            ->addColumn('accessLevel', function ($user) {
                if ($user['is_deleted'])
                    return '<p class="text-center m-0" style="color: darkred;"><i class="fa-solid fa-lock"></i></p>';

                return '<div class="d-flex justify-content-around">
                            <a class="js_access_level_btn mr-3 btn btn-outline-info btn-sm"
                                data-name="'.$user['name'].'"
                                data-one_url="'.route('accessUserLevel', ['userId' => $user['id']]).'"
                                data-update_url="'.route('accessUserLevel.update', ['userId' => $user['id']]).'"
                                href="javascript:void(0);" title="Access Level">
                                <i class="fa-solid fa-list-check"></i> '.trans('admin.Right of').'
                            </a>';
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
            ->rawColumns(['status', 'ldap', 'accessLevel', 'action'])
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
            'dep' => $data['dep'],
            'pos' => $data['pos'],
            'name' => $data['name'],
            'email' => $data['email'],
            'regcode' => strtolower($data['login']),
            'login' => strtolower($data['login']),
            'password' => Hash::make($data['password']) ?? null,
            'status' => $data['status'] ?? 0,
            'ldap' => $data['ldap'] ?? 0,
            'language' => $data['language'] ?? 'en',
        ]);

        return true;
    }

    public function update(array $data, int $id): int|bool
    {
        try {
            DB::beginTransaction();
                $user = $this->model::findOrfail($id);
                if (isset($data['password'])) {
                    $user->fill(['password' => Hash::make($data['password'])]);
                    // send email to admin
                    if ($id == 1) {
                        SendEmailAdminUpdateJob::dispatch([
                            'mail_to' => $data['email'],
                            'url' => URL::to('/'),
                            'login' => strtolower($data['login']),
                            'password' => $data['password'],
                        ])->onQueue('adminUpdate');

                    }
                }

                $user->fill([
                    'dep' => $data['dep'],
                    'pos' => $data['pos'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'login' => strtolower($data['login']),
                    'language' => $data['language'],
                    'ldap' => $data['ldap'],
                    'status' => $data['status'],
                ]);
                $user->save();
            DB::commit();
            return $id;
        }
        catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function destroy(int $id): int
    {
        User::where('id', $id)->update(['is_deleted'=> 1]);
        return $id;
    }

}
