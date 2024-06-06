<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Http\Resources\OrderActionResource;
use App\Models\Order;
use App\Models\OrderAction;
use App\Models\OrderDetail;
use App\Models\OrderFile;
use App\Models\UserPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class OrderActionService
{
    const ACCEPTED_STATUS = OrderStatus::ACCEPTED->value;
    const GO_BACK_STATUS = OrderStatus::GO_BACK->value;
    const COMPLETED_STATUS = OrderStatus::COMPLETED->value;

    public function action(array $data): int
    {
        try {
            DB::beginTransaction();
                $orderId = $data['order_id'];
                $status = $data['status'];

                $order = Order::with('user')->findOrFail($orderId);
                $orderCurrentInstanceId = $order->current_instance_id;
                $orderCurrentStage = $order->current_stage;

                //  business hours
//                $orderCreatedAt = $order->created_at;
//                $start = ($orderCurrentStage > 1)
//                    ? OrderAction::where('order_id', $orderId)->latest()->first()->created_at
//                    : $orderCreatedAt;
//                $end = now();
//                $time_signed = Helper::businessHours($start, $end);

                $actionStatus = self::ACCEPTED_STATUS;
                $actionStage = 1;
                $orderData = [
                    'status' => $actionStatus,
                    'current_instance_id' => $orderCurrentInstanceId,
                    'current_stage' => $actionStage
                ];

                if ($status == self::ACCEPTED_STATUS) {
                    if ($order->user_id == Auth::id() && $order->status->isGoBack()){

                        if ($this->isCheckUpdateOwner($order->id)){
                            $actionStage = $orderCurrentStage;
                            $orderData['status'] = self::ACCEPTED_STATUS;
                            $orderData['current_instance_id'] =  $this->newInstanceId($order, 1);
                            $orderData['current_stage'] = 1;
                        }else{
                            $actionStage = $orderCurrentStage;
                            $orderData['status'] = self::ACCEPTED_STATUS;
                            $orderData['current_instance_id'] = $orderCurrentInstanceId;
                            $orderData['current_stage'] = $orderCurrentStage;
                        }
                    }else{
                        if (($orderCurrentStage >= 1) && ($orderCurrentStage < $order->stage_count)) {
                            $actionStage = $orderCurrentStage;
                            $orderCurrentStage++;
                            $newCurrentInstanceId = $this->newInstanceId($order, $orderCurrentStage);

                            $orderData['status'] = self::ACCEPTED_STATUS;
                            $orderData['current_instance_id'] = $newCurrentInstanceId;
                            $orderData['current_stage'] = $orderCurrentStage;
                        } elseif ($orderCurrentStage == $order->stage_count) {
                            $actionStage = $orderCurrentStage;
                            $orderData['status'] = self::COMPLETED_STATUS;
                            $orderData['current_stage'] = $order->stage_count;
                        }
                    }
                } elseif ($status == self::GO_BACK_STATUS) {
                    $actionStatus = self::GO_BACK_STATUS;
                    $actionStage = $orderCurrentStage;
                    $orderData['status'] = self::GO_BACK_STATUS;
                    $orderData['current_stage'] = $orderCurrentStage;
                }

                $order->fill($orderData);
                $order->save();

                OrderAction::create([
                    'order_id' => $orderId,
                    'user_id' => Auth::id(),
                    'instance_id' => $orderCurrentInstanceId,
                    'status' => $actionStatus,
                    'stage' => $actionStage,
                    'time_signed' => "",
                    'comment' => ($data['comment']) ?? "",
                ]);

            DB::commit();

            return $orderId;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function newInstanceId(object $order, int $stage): int
    {
        return UserPlan::where([
            'user_id' => $order->user_id,
            'user_instance_id'=> $order->instance_id,
            'stage' => $stage
        ])->first()->instance_id;
    }


    public function getOrderAction(int $orderId): object
    {
        $orderAction = OrderAction::with(['user', 'instance'])
            ->where(['order_id' => $orderId])
            ->get();

        return OrderActionResource::collection($orderAction);
    }

    public function isCheckUpdateOwner(int $orderId):bool
    {
        $orderDetailsExists = OrderDetail::where(['order_id'=>$orderId,'status' => OrderDetail::STATUS_UPDATE])->exists();
        $orderFilesExists = OrderFile::where(['order_id'=>$orderId,'status' => OrderFile::STATUS_UPDATE])->exists();
        return $orderDetailsExists || $orderFilesExists;
    }
}
