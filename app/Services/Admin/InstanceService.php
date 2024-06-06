<?php

namespace App\Services\Admin;

use App\Models\Instance;
use Yajra\DataTables\DataTables;

class InstanceService
{
    public function list()
    {
        $instances = Instance::orderBy('id', 'DESC')->get();

        return DataTables::of($instances)
            ->addIndexColumn()
            ->addColumn('action', function ($instances) {
                $btn = '<div class="text-right">
                            <a href="javascript:void(0);" class="text-primary js_edit_btn mr-3"
                                data-update_url="'.route('admin.instance.update', $instances->id).'"
                                data-one_data_url="'.route('admin.instance.getOne', $instances->id).'"
                                title="Редактирование">
                                <i class="fas fa-pen mr-50"></i> '.trans("admin.Edit").'
                            </a>
                            <a class="text-danger js_delete_btn" href="javascript:void(0);"
                                data-toggle="modal"
                                data-target="#deleteModal"
                                data-name="'.$instances->name_ru.'"
                                data-url="'.route('admin.instance.destroy', $instances->id).'" title="Выключать">
                                <i class="far fa-trash-alt mr-50"></i> '.trans("admin.Delete").'
                            </a>
                        </div>';
                return $btn;
            })
            ->editColumn('id', '{{$id}}')
            ->editColumn('status', function($instances) {
                return ($instances->status == 1) ? trans('Admin.Active') : trans('Admin.No active');
            })
            ->setRowClass('js_this_tr')
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make();
    }

    public function one(int $id)
    {
        return Instance::findOrFail($id);
    }

    public function create(array $data)
    {
        return Instance::create([
            'name_ru' => $data['name_ru'],
            'status' => $data['status']
        ]);
    }

    public function update(array $data, int $id)
    {
        return Instance::where(['id'=> $id])
            ->update([
                'name_ru' => $data['name_ru'],
                'status' => $data['status']
            ]);
    }

    public function delete(int $id)
    {
        Instance::destroy($id);
        return $id;
    }

}

