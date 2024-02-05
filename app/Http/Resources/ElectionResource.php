<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ElectionResource extends JsonResource
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
            'name' => $this->name,
            'election_session' => $this->election_session,
            'election_date' => $this->election_date ? $this->election_date->format('d-m-Y') : null,
            'nomination_from_submission_deadline' => $this->nomination_from_submission_deadline ? $this->nomination_from_submission_deadline->format('d-m-Y') : null,
            'status' => $this->status,
            'chairman_name' => $this->chairman_name,
            'attachment_chairman_signature' => $this->attachment_chairman_signature,
        ];
    }
}
