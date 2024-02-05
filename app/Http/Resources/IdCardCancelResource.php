<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IdCardCancelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => (int) $this->id,
            'submit_date' => $this->submit_date ? $this->submit_date->format('d-m-Y') : null,
            'id_card' => $this->id_card_id ? new IdCardResource($this->id_card) : null,
            'status' => $this->status,
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : null,
            'updated_at' => $this->updated_at ? $this->created_at->format('d-m-Y') : null
        ];
    }
}
