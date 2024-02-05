<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IdCardResource extends JsonResource
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
            'card_type' => $this->card_type,
            'card_holder_name' => $this->card_holder_name,
            'id_card_number' => $this->id_card_number,
            'proximity_number' => $this->proximity_number,
            'card_holder_designation' => $this->card_holder_designation,
            'delivery_date' => $this->delivery_date ? $this->delivery_date->format('d-m-Y') : null,
            'training_date' => $this->training_date ? $this->training_date->format('d-m-Y') : null,
            'dob' => $this->dob ? $this->dob->format('d-m-Y') : null,
            'card_holder_photograph_attachment' => $this->card_holder_photograph_attachment,
            'police_verification' => $this->police_verification ? $this->police_verification->format('d-m-Y') : null,
            'police_verification_attachment' => $this->police_verification_attachment,
            'previous_year_id_card_number' => $this->previous_year_id_card_number,
            'office_address' => $this->office_address,
            'office_telephone' => $this->office_telephone,
            'blood_group' => $this->blood_group,

            'attachment_name' => $this->attachment_name,
            'attachment_number' => $this->attachment_number,
            'attachment_file' => $this->attachment_file,

            'status_code' => $this->status,
            'status' => \IdCardStatus::$positions[$this->status],
            'comment' => $this->member_comment,
            'form_year' => (int) $this->form_year,

            'company_owner' => $this->company_owner_id ? ($this->company_owner ? $this->company_owner->name : null) : null,
            'designation' => $this->designation,
            'memship_no' => $this->memship_no,
            'organizations' => $this->members->pluck('organization_name'),
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : null,
            'updated_at' => $this->updated_at ? $this->created_at->format('d-m-Y') : null,

            'id_card_cancel' => $this->id_card_cancel ? $this->id_card_cancel->status : null,
        ];
    }
}
