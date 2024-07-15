<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Helpers\Helper;
use App\Http\Resources\InstallOnceResource;
use App\Models\CategoryInstall;
use App\Models\Group;
use App\Models\Install;
use App\Models\InstallSendGroup;
use App\Models\InstallStage;
use App\Models\InstallStageRun;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class InstallService
{
    public function __construct(
        public Install $install
    ) {}

    public function category(): array
    {
        return CategoryInstall::where('status', 1)
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
//                return '<span class="badge rounded-pill '.$install->status->getCssClass().'">'.$install->status->getLabelText().'</span>';
                return $install->status->getTextWithStyle();
            })
            ->addColumn('action', function ($install) {
                $btn = '<div class="d-flex justify-content-around">
                            <a class="js_show_btn mr-3 btn btn-outline-info btn-sm"
                                data-url="'.route('install.getOne', $install->id).'"
                                href="javascript:void(0);" title="See">
                                <i class="fas fa-eye"></i>
                            </a>';

                if (
                    $install->status->isAdminNew() || $install->status->isGroupPostponed() ||
                    $install->status->isAdminPostponed() || $install->status->isAdminStopped()
                ) {
                    $btn .= '<a class="js_stop_btn mr-3 btn btn-outline-danger btn-sm"
                                data-url="'.route('install.stop', $install->id).'"
                                href="javascript:void(0);" title="To\'tatish">
                                <i class="fas fa-times"></i> To\'xtatish
                            </a>';
                }
                else {
                    $btn .= '<a class="mr-3 btn btn-outline-secondary btn-sm"
                                href="javascript:void(0);" title="Edit">
                                <i class="fas fa-lock"></i> To\'xtatish
                            </a>';
                }

                return $btn.'</div>';
            })
            ->setRowClass('js_this_tr')
            ->rawColumns(['phone', 'status', 'price', 'action'])
            ->setRowAttr(['data-id' => '{{ $id }}'])
            ->make();
    }

    public function one(int $id): object
    {
        $install = $this->install::with(['category', 'sendGroups'])->findOrFail($id);
        return new InstallOnceResource($install);
    }

    public function store(array $data): bool
    {
        DB::beginTransaction();
            $installId = $this->install::insertGetId([
                'category_id' => $data['category_id'],
                'blanka_number' => $data['blanka_number'],
                'name' => $data['name'],
                'phone' => $data['phone'],
                'area' => $data['area'],
                'address' => $data['address'],
                'location' => $data['location'],
                'description' => $data['description'],
                'price' => $data['price'],
                'status' => OrderStatus::adminNew->value,
                'creator_id' => Auth::id(),
            ]);

            foreach (InstallStage::get() as $stage) {
                InstallStageRun::create([
                    'install_id' => $installId,
                    'stage' => $stage->stage,
                    'text' => $stage->text,
                ]);
            }

            foreach ($data['group'] as $groupId) {
                if ($groupId != 0) {
                    InstallSendGroup::create([
                        'group_id' => $groupId,
                        'install_id' => $installId,
                        'status' => OrderStatus::adminNew->value
                    ]);
                }
            }
            // bot -> send for groups
//            if (in_array(0, $data['group'])) {
//                // all send groups
//            }
//            else {
//                // any send groups
//            }
        DB::commit();
        return true;
    }

    public function update(array $data, int $id): int
    {
        $install = $this->install::findOrFail($id);
        $install->fill([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'blanka_number' => $data['blanka_number'],
            'phone' => $data['phone'],
            'area' => $data['area'],
            'address' => $data['address'],
            'location' => $data['location'],
            'price' => $data['price'],
            'updater_id' => Auth::id()
        ]);
        $install->save();

        return $id;
    }

    public function stop(string $comment, int $id): int
    {
        $this->install::where('id', $id)
            ->update([
                'comment' => $comment,
                'status' => OrderStatus::adminStopped->value,
                'deleter_id' => Auth::id(),
                'deleted_at' => now(),
            ]);

        return $id;
    }

}
