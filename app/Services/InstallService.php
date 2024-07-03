<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Helpers\Helper;
use App\Models\CategoryInstallation;
use App\Models\Group;
use App\Models\GroupDetail;
use App\Models\GroupUser;
use App\Models\Installation;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class InstallService
{
    public function __construct(
        public Installation $install
    ) {}

    public function category(): array
    {
        return CategoryInstallation::where('status', 1)
            ->whereNull('deleted_at')
            ->withCount('install')
            ->get()
            ->toArray();
    }

    public function groups(): array
    {
        return Group::where('status', 1)
            ->whereNull('deleted_at')
            ->get()
            ->toArray();
    }

    public function install(int $id)
    {
        return $this->install::whereNull('deleted_at')
            ->when($id !== 0, function($query) use ($id) {
                $query->where('category_id', $id);
            })
            ->whereHas('category', function ($q) {
                $q->where('status', 1);
            })
            ->orderBy('id', 'DESC')
            ->get();
    }
    public function getInstall(int $id)
    {
        return DataTables::of($this->install($id))
            ->addIndexColumn()
            ->editColumn('id', '{{$id}}')
            ->editColumn('phone', function($install) {
                return Helper::phoneFormat($install->phone);
            })
            ->editColumn('price', function($install) {
                return Helper::moneyFormat($install->price);
            })
            ->editColumn('status', function($install) {
                return '<span class="badge rounded-pill '.$install->status->getCssClass().'">'.$install->status->getLabelText().'</span>';
            })
            ->addColumn('action', function ($install) {
                $btn = '<div class="d-flex justify-content-around">
                            <a class="js_show_btn mr-3 btn btn-outline-info btn-sm"
                                data-one_url="'.route('install.getOne', $install->id).'"
                                href="javascript:void(0);" title="See">
                                <i class="fas fa-eye"></i>
                            </a>';

                if (
                    $install->status->isAdminNew() || $install->status->isGroupPostponed() ||
                    $install->status->isAdminPostponed() || $install->status->isAdminStopped()
                ) {
                    $btn .= '<a class="js_edit_btn mr-3 btn btn-outline-primary btn-sm"
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
                            </a>';
                }
                else {
                    $btn .= '<a class="mr-3 btn btn-outline-secondary btn-sm"
                                href="javascript:void(0);" title="Edit">
                                <i class="fas fa-lock"></i>
                            </a>
                            <a class="btn btn-outline-secondary btn-sm"
                                href="javascript:void(0);" title="Delete">
                                <i class="fas fa-lock"></i>
                            </a>';
                }

                return $btn.'</div>';
            })
            ->setRowClass('js_this_tr')
            ->rawColumns(['phone', 'status', 'price', 'action'])
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make();
    }

    public function one(int $id)
    {
        return $this->install::with(['category'])->findOrFail($id);
    }

    public function store(array $data): bool
    {
        $this->install::insertGetId([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'area' => $data['area'],
            'address' => $data['address'],
            'location' => $data['location'],
            'price' => $data['price'],
            'status' => OrderStatus::adminNew->value
        ]);

        // bot -> send for groups
        if (in_array(0, $data['group'])) {
            // all send groups
        }
        else {
            // any send groups
        }

        return true;
    }

    public function update(array $data, int $id): int
    {
        $install = $this->install::findOrFail($id);
        $install->fill([
            'name' => $data['name'],
            'area' => $data['area'],
            'address' => $data['address'],
            'location' => $data['location'],
            'price' => $data['price'],
        ]);
        $install->save();

        return $id;
    }

    public function destroy(int $id): int
    {
        $this->install::where('id', $id)
            ->update([
                'deleter_id' => Auth::id(),
                'deleted_at' => now(),
            ]);

        return $id;
    }

}
