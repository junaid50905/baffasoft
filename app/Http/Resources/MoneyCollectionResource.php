<?php

namespace Vanguard\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MoneyCollectionResource extends JsonResource
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
            'receipt_no' => $this->voucher_no,
            'receipt_type' => $this->money_receipt_name ? $this->money_receipt_name: ($this->money_receipt_type ? $this->money_receipt_type->name : ''),
//            'name_of_shipper' => isset($this->member_name) ? $this->member_name : $this->member_detail->firm_name,
            'member_name' => isset($this->member_name) ? $this->member_name : (isset($this->member) ? $this->member->organization_name : ''),
            'member_no' => isset($this->member_no) ? $this->member_no : (isset($this->member) ? $this->member->username : ''),
            'amount' => $this->amount,
            'transaction_date' => $this->transaction_date ? $this->transaction_date->format('d-m-Y') : null,
            'payment_type' => $this->payment_type ? $this->payment_type : null,
            'receipt_year' => $this->receipt_year ? $this->receipt_year : null,
            'receipt_month' => $this->receipt_month ? $this->receipt_month : null,
            'payment_chq_no' => $this->payment_chq_no ? $this->payment_chq_no : null,
            'payment_chq_date' => $this->payment_chq_date ? $this->payment_chq_date->format('d-m-Y') : null,
            'payment_bank' => $this->payment_bank ? $this->payment_bank : null,
            'received_by' => isset($this->created_user_name) ? $this->created_user_name : (isset($this->created_user_id) ? $this->user->username : ''),
            'is_active' => (boolean) isset($this->created_user_id) ? true : false,
            'created_at' => $this->created_at ? $this->created_at->format('d-m-Y') : null
        ];
    }
}
