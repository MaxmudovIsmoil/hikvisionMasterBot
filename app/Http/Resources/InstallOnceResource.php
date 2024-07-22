<?php

namespace App\Http\Resources;

use App\Helpers\Helper;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Opcodes\LogViewer\Logs\Log;

class InstallOnceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = '';
        $comment = '';
        $stopDate = '';
        if ($this->comment != null) {
            \Illuminate\Support\Facades\Log::info(json_encode($this->comment['userId']));
            $user = \App\Models\User::findOrfail($this->comment['userId'])->name;
            $comment = $this->comment['comment'];
            $stopDate = $this->comment['deleted_at'];
        }
        return [
            'category' => $this->category->name,
            'blanka_number' => $this->blanka_number,
            'name' => $this->name,
            'phone' => Helper::phoneFormat($this->phone),
            'area' => $this->area,
            'address'=> $this->address,
            'location'=> $this->location,
            'quantity'=> $this->quantity,
            'price'=> Helper::moneyFormat($this->price),
            'description'=> $this->description,
            'stop_user'=> $user,
            'stop_comment'=> $comment,
            'stop_date' => $stopDate,
            'status'=> $this->status->getLabelText(),
            'created_at' => date('d.m.Y H:i', strtotime($this->created_at)),
            "groups" => InstallSendGroupResource::collection($this->sendGroups)
        ];
    }
}
