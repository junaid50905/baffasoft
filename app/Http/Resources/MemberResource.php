<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'username' => $this->username,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null,
            'status' => $this->status,
            'organization_name' => $this->organization_name,
            'gatepass_balance' => $this->gatepass_balance,
            'member_detail' => new MemberDetailResource($this->whenLoaded('member_detail')),
            'member_address' => MemberAddressResource::collection($this->whenLoaded('member_address')),
//            'head_office_address' => MemberAddressResource::collection($this->whenLoaded('member_address')),
            'company_owners' => CompanyOwnerResource::collection($this->whenLoaded('company_owners')),
            'signatory' => $this->whenLoaded('signatory') ? CompanyOwnerResource::collection($this->signatory)->first() : null,
            'voter_name' => isset($this->voter[0]) ? $this->voter[0]->name : null,
            'head_office' => new MemberAddressResource($this->whenLoaded('head_office')),
            'privileges' => PrivilegeResource::collection($this->whenLoaded('privileges')),
        ];
    }
}
