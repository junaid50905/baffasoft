<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VerificationResource extends JsonResource
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
            'member_id' => $this->member_id,
            'money_collection_id' => $this->money_collection_id,
            'verification_date' => $this->verification_date ? $this->verification_date->format('Y-m-d') : null,
            'form_year' => $this->form_year,
            'approved_date' => $this->approved_date ? $this->approved_date->format('Y-m-d') : null,
            'verification_required' => $this->verification_required,
            'verification_accept' => $this->verification_accept,
            'manager_note' => $this->manager_note,
            'member_message' => $this->member_message,
            'is_approved' => $this->is_approved,
            'is_payment' => $this->is_payment,
            'id_cards' => IdCardResource::collection($this->whenLoaded('id_cards')),
        ];
    }
}
