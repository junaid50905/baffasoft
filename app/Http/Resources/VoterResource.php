<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VoterResource extends JsonResource
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
            'manager_id' => $this->manager_id,
            'company_owner_id' => $this->company_owner_id,
            'election_id' => $this->election_id,
            'member' => isset($this->member) ? $this->member->organization_name : null,
            'election' => isset($this->election) ? new ElectionResource($this->election) : null, //$this->election->election_session : null,
            'company_owner' => isset($this->company_owner) ? $this->company_owner : null,
            'voter_name'=> $this->voter_name,
            'voter_designation'=> $this->voter_designation,
            'voter_e_tin_no'=> $this->voter_e_tin_no,
            'voter_e_tin_attachment'=> $this->voter_e_tin_attachment,
            'voter_nid_no'=> $this->voter_nid_no,
            'voter_address'=> $this->voter_address,
            'voter_tel'=> $this->voter_tel,
            'voter_mob'=> $this->voter_mob,
            'voter_fax'=> $this->voter_fax,
            'voter_email'=> $this->voter_email,
            'voter_signature'=> $this->voter_signature,
            'voter_image'=> $this->voter_image,
            'voter_location'=> $this->voter_location,
            'vote_casting_location'=> $this->vote_casting_location,
            'vote_cast'=> $this->vote_cast,

            'manager'=> isset($this->manager) ? $this->manager : null,
            'manager_signature'=> $this->manager_signature,
            'manager_name'=> $this->manager_name,
            'manager_designation'=> $this->manager_designation,
            'manager_date'=> $this->manager_date ? $this->manager_date->format('d-m-Y') : null,

            'due_list'=> (boolean) $this->due_list,
            'preliminary_list'=> (boolean) $this->preliminary_list,
            'final_list'=> (boolean) $this->final_list,
            'voter_number'=> $this->voter_number,
            'archived'=> (boolean) $this->archived,
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : null
        ];
    }
}
