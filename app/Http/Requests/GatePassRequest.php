<?php

namespace Vanguard\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GatePassRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'member_id' => 'numeric',
            'master_airway_bill_no' => 'required|unique:gate_passes,master_airway_bill_no|string|max:50',
//            'firm_name' => 'required|string|max:100',
//            'attach_nid' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'attach_id_card_or_passport' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//            'company_owner.*.email' => 'required|email|unique:company_owners,email',
//            'email_address' => 'required|string|email|max:50|unique:members',
//            'password' => 'required|string|min:6|confirmed',
//            'phone_number' => 'required|numeric|min:5'

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'master_airway_bill_no.required' => 'Please, Input Master Airway bill No.',
//            'company_owner.*.email.*' => 'The Company Owners E-mail Address must be required',
        ];
    }

    public function attributes()
    {
        return [
            'master_airway_bill_no' => 'Master Airway bill No.',
            'company_owner.*.email' => 'Company Owners'
        ];
    }


}
