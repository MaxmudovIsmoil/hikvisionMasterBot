<?php

namespace App\Http\Resources;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceOnceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'blanka_number' => $this->blanka_number,
            'name' => $this->name,
            'area' => $this->area,
            'address'=> $this->address,
            'location'=> $this->location,
            'price'=> $this->price ? Helper::moneyFormat($this->price): '',
            'description'=> $this->description,
            'comment'=> $this->comment,
            'status'=> $this->status->getTextWithStyle(),
            'created_at' => date('d.m.Y H:i', strtotime($this->created_at)),
            "groups" => ServiceSendGroupResource::collection($this->sendGroups)
        ];
    }
}
