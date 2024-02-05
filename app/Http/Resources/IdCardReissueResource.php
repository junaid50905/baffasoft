<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IdCardReissueResource extends JsonResource
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
            'attachment_file' => $this->attachment_file,
            'id_card' => $this->id_card_id ? new IdCardResource($this->id_card) : null,
            'is_payment' => (int) $this->is_payment,
            'reissue_reason' => $this->reissue_reason,
            'status' => $this->status,
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : null,
            'updated_at' => $this->updated_at ? $this->created_at->format('d-m-Y') : null
        ];
    }
}
