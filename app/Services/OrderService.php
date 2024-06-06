<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Http\Resources\UserPlanResource;
use App\Models\Order;
use App\Models\OrderAction;
use App\Models\OrderDetail;
use App\Models\OrderFile;
use App\Models\UserInstance;
use App\Models\UserPlan;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class OrderService
{
    use FileTrait;

    public function getUserPlan(): object
    {
        return UserInstance::where(['user_id' => Auth::id()])
            ->with('instance')
            ->get();
    }

    public function userInstanceIds()
    {
        $userInstances = UserInstance::where(['user_id' => Auth::id()])->get('instance_id');
        $instance_ids = [];
        foreach ($userInstances as $userInstance) {
            $instance_ids[] = $userInstance->instance_id;
        }
        return $instance_ids;
    }

    public function getOrder(int $status = null)
    {
        $userInstanceIds = $this->userInstanceIds();

        $orderQuery = Order::select('o.id as order_id', 'o.user_id', 'o.instance_id', 'o.theme',
            'o.stage_count', 'o.status', 'o.current_stage', 'o.current_instance_id',
            'up.instance_id as up_instance_id', 'up.stage as up_stage',
            'up.user_instance_id as up_user_instance_id')
            ->from('orders as o')
            ->leftJoin('user_plans as up', function ($join) {
                $join->on('up.user_instance_id', '=', 'o.instance_id')
                    ->on('up.user_id', '=', 'o.user_id');
            })
            ->leftJoin('order_actions as oa', function ($join) {
                $join->on('oa.order_id', '=', 'o.id');
            })
            ->with(['user', 'instance', 'currentInstance'])
            ->where(function ($query) use ($userInstanceIds) {
                $query->where(function ($query) use ($userInstanceIds) {
                    $query->where(function ($query) use ($userInstanceIds) {
                        $query->whereIn('up.instance_id', $userInstanceIds)
                            ->where('up.stage', '<=', DB::raw('o.current_stage'));
                    })->orWhere(function ($query) use ($userInstanceIds) {
                        $query->whereIn('up.instance_id', $userInstanceIds)
                            ->whereIn('oa.instance_id', $userInstanceIds);
                    });
                })
                ->whereIn('up.user_instance_id', $userInstanceIds, 'or');
            });


            if(!is_null($status)){
                $orderQuery = $orderQuery->where(['o.status' => $status]);
            }

            $orders = $orderQuery->groupBy('o.id')
                ->orderBy('o.id', 'DESC')
                ->orderBy('o.current_stage', 'ASC')
                ->paginate(20);

        return $orders;
    }



    public function create(object $data): int
    {
        if ($data->theme == '')
            throw new \Exception(message:'requiredTheme', code: 400);

        $stageCount = UserPlan::where([
            'user_id' => Auth::id(),
            'user_instance_id' => $data->instance_id
        ])->count();

        if ($stageCount == 0) {
            throw new \Exception('userPlanEmpty');
        }

        $current_instance_id = UserPlan::where([
            'user_id' => Auth::id(),
            'user_instance_id' => $data->instance_id,
            'stage' => 1
        ])->first()->instance_id;

        DB::beginTransaction();

            $orderId = Order::insertGetId([
                'user_id' => Auth::id(),
                'instance_id' => $data->instance_id,
                'theme' => $data->theme,
                'current_instance_id' => $current_instance_id,
                'stage_count' => $stageCount,
                'status' => OrderStatus::ACCEPTED,
                'current_stage' => 1,
            ]);

            $this->filesUpload($data, $orderId);

            $this->orderDetailStore($data, $orderId);

        DB::commit();
        return $orderId;
    }



    public function orderDetailStore(object $data, int $orderId): void
    {
        for($i = 0; $i < count($data->name); $i++) {
            if ($data->name[$i] != '') {
                OrderDetail::create([
                    'order_id' => $orderId,
                    'name' => $data->name[$i] ?? "",
                    'count' => $data->count[$i] ?? NULL,
                    'pcs' => $data->pcs[$i] ?? "",
                    'purpose' => $data->purpose[$i] ?? "",
                    'address' => $data->address[$i] ?? "",
                    'status' => OrderDetail::STATUS_DEFAULT,
                    'approximate_price' => $data->approximate_price[$i] ?? "",
                ]);
            }
        }
    }


    public function filesUpload(object $data, int $orderId): void
    {
        if ($data->hasfile('upload')) {
            foreach ($data->file('upload') as $file) {
                $file_name = $this->fileUpload($file,  'files');

                OrderFile::create([
                    'order_id' => $orderId,
                    'user_id' => Auth::id(),
                    'file' => $file_name,
                ]);
            }
        }
    }


    public function getOrderActionComments(int $orderId)
    {
        $orderAction = OrderAction::with(['user', 'instance'])
            ->where(['order_id' => $orderId])
            ->get();

        return ($orderAction->count() !== 0)
            ? $this->getOrderActionCommentDiv($orderAction)
            : 'Not Comments';
    }

    public function getOrderActionCommentDiv(object $orderAction): string
    {
        $div = "";
        foreach ($orderAction as $action) {
            $class = 'bg-light-success';
            if ($action->status->isGoBack()) {
                $class = 'bg-light-warning';
            }
            else if($action->status->isDeclined()) {
                $class = 'bt-light-danger';
            }

            $div .= '<div class="order-card '.$class.'">' .
                '<div class="d-flex justify-content-left align-items-center">' .
                '    <div class="avatar-wrapper">' .
                '        <div class="avatar avatar-xl mr-1">' .
                '            <img src="' . asset("storage/upload/photos/".$action->user->photo) . '" alt="Avatar" height="32" width="32">' .
                '        </div>' .
                '    </div>' .
                '    <div class="d-flex flex-column"><a href="#" class="user_name text-truncate">' .
                '        <span class="font-weight-bold">'.$action->user->name.'</span></a>' .
                '        <small class="emp_post text-muted">'.$action->instance->name_ru.'</small>' .
                '    </div>' .
                '</div>' .
                '<div class="comment">'.$action->comment.'</div>'.
                '<i class="fas fa-arrow-right"></i>' .
                '</div>';
        }
        return $div;
    }


    public function getOrderPlan(int $orderId)
    {
        $order = Order::findOrFail($orderId)->first(['user_id', 'instance_id']);

        $userPlan = UserPlan::where([
            'user_id' => $order->user_id,
            'user_instance_id' => $order->instance_id
        ])->with(['instance', 'userInstance', 'userInstance.user'])->get();

        return UserPlanResource::collection($userPlan);
    }
}
