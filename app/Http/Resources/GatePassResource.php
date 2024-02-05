<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GatePassResource extends JsonResource
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
            'master_airway_bill_no' => $this->master_airway_bill_no,
            'contents' => $this->contents,
            'weight' => $this->weight,
            'flight_no' => $this->flight_no,
            'destination' => $this->destination,
            'routing' => $this->routing,
            'shipper_invoice_no' => $this->shipper_invoice_no,
            'date' => $this->date ? $this->date->format('d-m-Y') : null,
            'agent_name' => $this->agent_name,
            'agent_id_no' => $this->agent_id_no,
            'no_of_piece' => $this->no_of_piece,
            'gross_weight' => $this->gross_weight,
            'cbm' => $this->cbm,
            'vwt' => $this->vwt,
            'chargeable_weight' => $this->chargeable_weight,
            'dimensioni' => $this->dimensioni,
            'dimensionii' => $this->dimensionii,
            'dimensioniii' => $this->dimensioniii,
            'dimensioniv' => $this->dimensioniv,
            'dimensionv' => $this->dimensionv,
            'dimensionvi' => $this->dimensionvi,
            'member_id' => isset($this->member) ? $this->member->id : 0,
            'bmn' => isset($this->bmn) ? $this->bmn : $this->member->username,
            'name_of_shipper' => isset($this->member_name) ? $this->member_name : (isset($this->member_id) ? $this->member->organization_name : 'No Member'),
            'on_behalf_of_member_name' => isset($this->on_behalf_of_member_name) ? $this->on_behalf_of_member_name : (isset($this->on_behalf_of_member) ? $this->on_behalf_of_member->organization_name : 'No Member'),
            'created_by' => isset($this->created_by) ? $this->created_by : (isset($this->created_user_id) ? $this->created_user->username : $this->created_user_name),
            'updated_by' => isset($this->updated_by) ? $this->updated_by : (isset($this->updated_user_id) ? $this->updated_user->username : 'No User'),
            'balance_amount' => isset($this->member) ? $this->member->gatepass_balance : 0.00,

//            'print_times' => (boolean) $this->print_times >= 3 ? false : true,
            'is_active' => (boolean) $this->is_active,
            'is_submit' => (boolean) $this->is_submit,
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : null,
            'updated_at' => $this->updated_at ? $this->created_at->format('d-m-Y') : null,
            'is_payment' => isset($this->payments) ? (boolean) $this->payments->count() : false,
//            'payment' => isset($this->payment->amount) ? $this->payment->amount : null // ? $this->payment->amount ? $this->payment->amount : null : null,
            'payments' => isset($this->payments) ? PaymentResource::collection($this->whenLoaded('payments'))->collection->groupBy('bmn') : null,
        ];
    }
}
