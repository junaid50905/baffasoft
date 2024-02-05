<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberDetailResource extends JsonResource
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
            'is_payment' => (int) $this->is_payment,
            'last_renew_year' => (int) $this->last_renew_year,

            'form_submit_date' => $this->form_submit_date ? $this->form_submit_date->format('Y-m-d') : null,
//            'firm_name' => $this->firm_name,
            'place_of_enlistment' => $this->place_of_enlistment,

            'firm_type' => $this->firm_type,
            'attach_article' => $this->attach_article,

            'type_local' => $this->type_local,
            'particulars_of_certificate_number' => $this->particulars_of_certificate_number,
            'particulars_of_certificate_date' => $this->particulars_of_certificate_date ? $this->particulars_of_certificate_date->format('Y-m-d') : null,
            'attach_incorporation_certificate' => $this->attach_incorporation_certificate,

            'date_of_establishment' => $this->date_of_establishment ? $this->date_of_establishment->format('Y-m-d') : null,
            'trade_license_number' => $this->trade_license_number,
            'trade_license_date' => $this->trade_license_date ? $this->trade_license_date->format('Y-m-d') : null,
            'attach_trade_license' => $this->attach_trade_license,
            'tin_number' => $this->tin_number,
            'attach_e_tin_certificate' => $this->attach_e_tin_certificate,
            'vat_registration_number' => $this->vat_registration_number,
            'attach_vat_registration_certificate' => $this->attach_vat_registration_certificate,

            'ff_license_no' => $this->ff_license_no,
            'attach_ff_license_no' => $this->attach_ff_license_no,


            'name_of_banker' => $this->name_of_banker,
            'address_of_banker' => $this->address_of_banker,
            'attach_bank_solvency_certificate' => $this->attach_bank_solvency_certificate,

            'membership_of_other_trade_organization' => $this->membership_of_other_trade_organization,
            'attach_membership_of_other_trade_organization' => $this->attach_membership_of_other_trade_organization,
            'name_of_authorized_person' => $this->name_of_authorized_person,

            'no_of_appointed_staff' => $this->no_of_appointed_staff,
            'attach_no_of_appointed_staff' => $this->attach_no_of_appointed_staff,

            'warehouse_office_address' => $this->warehouse_office_address,
            'warehouse_office_floor_area' => $this->warehouse_office_floor_area,

            'other_org' => $this->other_org,

            'attach_proposed_seconded_by' => $this->attach_proposed_seconded_by,
            'attach_declaration_undertaking' => $this->attach_declaration_undertaking,

            'attach_inspection_report' => $this->attach_inspection_report,
            'attach_checklist' => $this->attach_checklist,
            'sub_committee_meeting_date' => $this->sub_committee_meeting_date ? $this->sub_committee_meeting_date->format('Y-m-d') : null,
            'board_of_directors_meeting_no' => $this->board_of_directors_meeting_no,
            'board_of_directors_meeting_date' => $this->board_of_directors_meeting_date ? $this->board_of_directors_meeting_date->format('Y-m-d') : null,
            'board_of_directors_meeting_year' => $this->board_of_directors_meeting_date ? $this->board_of_directors_meeting_date->format('Y') : null,

            'attach_relevent_document_1' => $this->attach_relevent_document_1,
            'attach_relevent_document_2' => $this->attach_relevent_document_2,
            'attach_relevent_document_3' => $this->attach_relevent_document_3,


            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null,
        ];
    }
}
