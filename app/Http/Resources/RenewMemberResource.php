<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Vanguard\Member;

class RenewMemberResource extends JsonResource
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
//            'member' => isset($this->member_id) ? new MemberResource($this->member) : null,
//            'member_detail' => isset($this->member_id) ? new MemberDetailResource($this->member_detail) : null,
            'member_address' => $this->renew_member_address,
            'submission_year' => $this->submission_year,
            'date_of_renewal' => $this->date_of_renewal ? $this->date_of_renewal->format('Y-m-d') : null,
            'firm_name' => $this->firm_name,
            'firm_type' => $this->firm_type,
            'type_local' => $this->type_local,
            'contact_person_name' => $this->contact_person_name,
            'contact_person_designation' => $this->contact_person_designation,
            'contact_person_designation_other' => $this->contact_person_designation_other,
            'contact_person' => $this->whenLoaded('contact_person') ? CompanyOwnerResource::collection($this->contact_person)->first() : null,
            'membership_number' => $this->membership_number,
            'date_of_admission' => $this->date_of_admission ? $this->date_of_admission->format('Y-m-d') : null,
            'place_of_enlistment' => $this->place_of_enlistment,

            'registered_office' => $this->registered_office,
            'current_office' => $this->current_office,
            'branch_office' => $this->branch_office,

            'telephone_no' => $this->telephone_no,
            'fax_no' => $this->fax_no,
            'mobile_no' => $this->mobile_no,
            'email_address' => $this->email_address,
            'website' => $this->website,

            'freight_forwarders_license_number' => $this->freight_forwarders_license_number,
            'freight_forwarders_license_date' => $this->freight_forwarders_license_date ? $this->freight_forwarders_license_date->format('Y-m-d') : null,

            'attach_ff_license_no' => $this->attach_ff_license_no,
            'attach_trade_license' => $this->attach_trade_license,
            'attach_e_tin_certificate' => $this->attach_e_tin_certificate,

            'trade_license_number' => $this->trade_license_number,
            'trade_license_date' => $this->trade_license_date ? $this->trade_license_date->format('Y-m-d') : null,

            'tin_number' => $this->tin_number,
            'any_change' => $this->any_change,
            'structure_change' => $this->structure_change,
            'structure_change_charge' => $this->structure_change_charge,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null
        ];
    }
}
