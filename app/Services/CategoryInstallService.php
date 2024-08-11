<?php

namespace App\Services;

use App\Models\CategoryInstall;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CategoryInstallService
{
    public function __construct(
        protected CategoryInstall $modal,
    ) {}

    public function all()
    {
        $modal = $this->modal
            ->get()
            ->toArray();

        return DataTables::of($modal)
            ->addIndexColumn()
            ->editColumn('id', '{{$id}}')
            ->editColumn('status', function($modal) {
                return $modal['status']
                    ? '<div class="text-center"><i class="fas fa-check text-success"></i></div>'
                    : '<div class="text-center"><i class="fas fa-times text-danger"></i></div>';
            })
            ->addColumn('action', function ($modal) {
                return '<div class="d-flex justify-content-around">
                            <a class="js_edit_btn mr-3 btn btn-outline-primary btn-sm"
                                data-update_url="'.route('categoryInstall.update', $modal['id']).'"
                                data-one_url="'.route('categoryInstall.getOne', $modal['id']).'"
                                href="javascript:void(0);" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a class="js_delete_btn btn btn-outline-danger btn-sm"
                                data-toggle="modal" data-target="#deleteModal"
                                data-name="'.$modal['name'].'"
                                data-url="'.route('categoryInstall.destroy', $modal['id']).'"
                                href="javascript:void(0);" title="Delete">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </div>';
            })
            ->setRowClass('js_this_tr')
            ->rawColumns(['status', 'action'])
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make();
    }

    public function one(int $id): array
    {
        return $this->modal->findOrFail($id)->toArray();
    }

    public function store(array $data): bool
    {
        $this->modal::create([
                'name' => $data['name'],
                'status' => $data['status'],
                'creator_id' => Auth::id(),
                'updater_id' => Auth::id()
            ]);
        return true;
    }

    public function update(array $data, int $id): int
    {

        $this->modal::where('id', $id)
            ->update([
                'name' => $data['name'],
                'status' => $data['status'],
                'updater_id' => Auth::id()
            ]);
        return $id;
    }

    public function destroy(int $id): int
    {
        $this->modal::destroy($id);
        return $id;
    }

}
