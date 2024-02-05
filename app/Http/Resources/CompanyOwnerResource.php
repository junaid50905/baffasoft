<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyOwnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'designation' => $this->designation,
            'nid_no' => $this->nid_no,
            'attach_nid' => $this->attach_nid,
            'educational_qualification' => $this->educational_qualification,
            'attach_educational_qualification' => $this->attach_educational_qualification,
            'attach_photograph' => $this->attach_photograph,
            'mobile_no' => $this->mobile_no,
            'email' => $this->email,
            'nationality_id' => (int) $this->nationality_id,
            'nationality_name' => $this->nationality_id ? $this->nationality->name : null,
            'attach_signature' => $this->attach_signature,
            'experience_year' => $this->experience_year,
            'attach_experience_certificate' => $this->attach_experience_certificate,
            'signatory' => (int) $this->signatory,
            'nominate_for_vote' => (int) $this->nominate_for_vote,
            'authorized_person' => (int) $this->authorized_person,
            'is_active' => (boolean) $this->is_active,
            'is_deleted' => (boolean) $this->is_deleted,
            'renew_member_status' => isset($this->renew_members) ? ((boolean) $this->renew_members->count() ? $this->renew_members->first()->status : null) : null
//            'flag' => $this->flag ? url("flags/{$this->flag}") : null
        ];
    }
}
