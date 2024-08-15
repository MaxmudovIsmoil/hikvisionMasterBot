<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Helpers\Helper;
use App\Http\Resources\ServiceOnceResource;
use App\Jobs\InstallOrServiceSendTelegram;
use App\Models\Group;
use App\Models\Service;
use App\Models\ServiceSendGroup;
use App\Models\ServiceStage;
use App\Models\ServiceStageRun;
use App\Telegram\Helpers\InstallOrServiceTelegram;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ServiceService
{
    public function __construct(
        private Service $service
    ) {}

    public function groups(): array
    {
        return Group::where('status', 1)
            ->whereNull('deleted_at')
            ->get()
            ->toArray();
    }

    public function count()
    {
        return $this->service->count();
    }

    public function getServices()
    {
        $service = $this->service::whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get();

        return DataTables::of($service)
            ->addIndexColumn()
            ->editColumn('id', '{{$id}}')
            ->editColumn('phone', function($service) {
                return Helper::phoneFormat($service->phone);
            })
//            ->editColumn('price', function($service) {
//                return Helper::moneyFormat($service->price);
//            })
            ->editColumn('status', function($service) {
                return $service->status->getTextWithStyle();
            })
            ->addColumn('action', function ($service) {
                $btn = '<div class="d-flex justify-content-around">
                            <a class="js_show_btn mr-3 btn btn-outline-info btn-sm"
                                data-url="'.route('service.getOne', $service->id).'"
                                href="javascript:void(0);" title="See">
                                <i class="fas fa-eye"></i>
                            </a>';

                if (
                    $service->status->isUserNew() || $service->status->isGroupPostponed() ||
                    $service->status->isUserPostponed() || $service->status->isUserStopped()
                ) {
                    $btn .= '<a class="js_edit_btn mr-3 btn btn-outline-danger btn-sm"
                                data-update_url="'.route('service.update', $service->id).'"
                                data-one_url="'.route('service.getOne', $service->id).'"
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
        $service = $this->service::with(['sendGroups'])->findOrFail($id);
        return new ServiceOnceResource($service);
    }

    public function store(array $data): bool
    {
        DB::beginTransaction();
            $serviceId = $this->service::insertGetId([
                'blanka_number' => $data['blanka_number'],
                'name' => $data['name'],
                'phone' => $data['phone'],
                'area' => $data['area'],
                'address' => $data['address'],
                'location' => $data['location'],
                'description' => $data['description'],
                'price' => $data['price'],
                'status' => OrderStatus::userNew->value,
                'creator_id' => Auth::id(),
            ]);

            foreach (ServiceStage::get() as $stage) {
                ServiceStageRun::create([
                    'service_id' => $serviceId,
                    'stage' => $stage->stage,
                    'text' => $stage->text,
                ]);
            }

            foreach ($data['group'] as $groupId) {
                if ($groupId != 0) {
                    ServiceSendGroup::create([
                        'group_id' => $groupId,
                        'service_id' => $serviceId,
                        'status' => OrderStatus::userNew->value
                    ]);
                    // bot -> send for groups
//                    $text = InstallOrServiceTelegram::getSendText(2, $data);
//                    InstallOrServiceTelegram::send(2, $serviceId, $groupId, $text);
                    InstallOrServiceSendTelegram::dispatch(type: 2, id: $serviceId, groupId: $groupId, data: $data);
                }
            }

        DB::commit();
        return true;
    }

    public function update(array $data, int $id): int
    {
        $service = $this->service::findOrFail($id);
        $service->fill([
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
        $service->save();

        return $id;
    }

    public function destroy(int $id): int
    {
        $this->service::where('id', $id)
            ->update([
                'deleter_id' => Auth::id(),
                'deleted_at' => now(),
            ]);

        return $id;
    }

}
