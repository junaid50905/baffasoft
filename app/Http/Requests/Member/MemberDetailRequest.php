<?php

namespace Vanguard\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class MemberDetailRequest extends FormRequest
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
            'form_submit_date' => 'required|string|max:50',
//            'firm_name' => 'required|string|max:100',

            'attach_article' =>       'mimes:jpeg,png,jpg,pdf|max:10240',
            'attach_incorporation_certificate' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
            'attach_trade_license' =>       'mimes:jpeg,png,jpg,pdf|max:10240',
            'attach_e_tin_certificate' =>       'mimes:jpeg,png,jpg,pdf|max:10240',
            'attach_vat_registration_certificate' =>       'mimes:jpeg,png,jpg,pdf|max:2048',

            'company_owner.*.attach_nid' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
            'company_owner.*.attach_educational_qualification' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
            'company_owner.*.attach_photograph' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
            'company_owner.*.attach_signature' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
            'company_owner.*.attach_experience_certificate' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
//            'company_owner.*.email' => 'required|email|unique:company_owners,email',

            'attach_ff_license_no' =>       'mimes:jpeg,png,jpg,pdf|max:10240',
            'attach_bank_solvency_certificate' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
            'attach_membership_of_other_trade_organization' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
            'attach_no_of_appointed_staff' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
            'attach_proposed_seconded_by' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
            'attach_declaration_undertaking' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
            'attach_inspection_report' =>       'mimes:jpeg,png,jpg,pdf|max:2048',
            'attach_checklist' =>       'mimes:jpeg,png,jpg,pdf|max:10240',

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
            'form_submit_date.required' => 'Please, Input a valid Date.'
//            'company_owner.*.email.*' => 'The Company Owners E-mail Address must be required',
//            'company_owner.*.*' => 'The Company Owners Attachment :message',
        ];
    }

    public function attributes()
    {
        return [
            'attach_id_card_or_passport' => 'Attach ID Card/Passport',
            'company_owner.*.attach_nid' => 'Company Owners NID',
            'company_owner.*.attach_educational_qualification' => 'Company Owners Educational Certificate',
            'company_owner.*.attach_photograph' =>' Company Owners attach_photograph',
            'company_owner.*.attach_signature' => 'Company Owners Signature',
            'company_owner.*.attach_experience_certificate' => 'Company Owners Experience Certificate'
        ];
    }
}
