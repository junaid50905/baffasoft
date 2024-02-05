<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrainingResource extends JsonResource
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
            'member' => isset($this->member) ? $this->member->organization_name : null,
            'participant_id' => $this->participant_id,
            'participant_name' => isset($this->participant) ? $this->participant->name : null,
            'director_id' => $this->director_id,
            'director_name' => isset($this->director) ? $this->director->name : null,
            'director_signature' => isset($this->director) ? $this->director->attach_signature : null,

            'title' => $this->title,
            'category_name' => $this->category_name,
            'is_payment' => (int) $this->is_payment,
            'money_collection_id' => (int) $this->money_collection_id,
            'money_collection_no' => isset($this->money_collection) ? $this->money_collection->voucher_no : null,
            'money_collection_date' => isset($this->money_collection) ? $this->money_collection->transaction_date->format('d-m-Y') : null,
            'money_collection_amount' => isset($this->money_collection) ? $this->money_collection->amount : null,

            'training_name' => strtoupper($this->training_name),
            'other_training_name' => $this->other_training_name,
            'organization_address' => $this->organization_address,

            'participant_name' => $this->participant_name,
            'participant_designation' => $this->participant_designation,
            'participant_tel' => $this->participant_tel,
            'participant_mobile' => $this->participant_mobile,
            'participant_email' => $this->participant_email,
            'participant_dob' => $this->participant_dob ? $this->participant_dob->format('d-m-Y') : null,
            'participant_qualification' => $this->participant_qualification,
            'participant_experience' => $this->participant_experience,
            'id_card_id' => $this->id_card_id,
            'id_card_number' =>  isset($this->id_card) ? $this->id_card->id_card_number : null,
            'previous_caab_id_no' => isset($this->id_card) ? $this->id_card->caab_id_no : null,

            'applicant_signature' => $this->applicant_signature,
            'applicant_national_id_card' => isset($this->id_card) ? $this->id_card->attachment_name : null,
            'applicant_national_id_card_number' => isset($this->id_card) ? $this->id_card->attachment_number : null,
            'applicant_national_id_card_attachment' => isset($this->id_card) ? $this->id_card->attachment_file : null,
            'applicant_police_verification_date' => isset($this->id_card) ? ($this->id_card->police_verification ? $this->id_card->police_verification->format('d-m-Y') : null) : null,
            'applicant_police_verification_attachment' => isset($this->id_card) ? $this->id_card->police_verification_attachment : null,
            'applicant_photograph_attachment' => isset($this->id_card) ? $this->id_card->card_holder_photograph_attachment : null,
            'applicantion_date' => $this->applicantion_date ? $this->applicantion_date->format('d-m-Y') : null,
            'submission_year' => $this->submission_year,

            'certificate_number' => $this->certificate_number,
            'certificate_validity' => $this->certificate_validity ? $this->certificate_validity->format('d-m-Y') : null,
            'delivery_date' => $this->delivery_date ? $this->delivery_date->format('d-m-Y') : null,
            'caab_id_no' => $this->caab_id_no,
            'file_number' => $this->file_number,
            'status' => $this->status,
            'created_by' => isset($this->created_user_id) ? $this->created_user->username : $this->created_user_name,
            'updated_by' => isset($this->updated_user_id) ? $this->updated_user->username : 'No User',
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : null,
            'updated_at' => $this->updated_at ? $this->created_at->format('d-m-Y') : null,
        ];
    }
}
