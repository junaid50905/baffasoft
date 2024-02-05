<?php

namespace Vanguard\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IdCardRequest extends FormRequest
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
            'card_holder_name' => 'required|string|max:50',
            'attachment_file' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
            'police_verification_attachment' => 'mimes:jpeg,png,jpg,pdf|max:2048',
            'card_holder_photograph_attachment' => 'required|mimes:jpeg,png,jpg|max:2048',
            'signatory_attachment' => 'required|mimes:jpeg,png,jpg|max:2048',
            'card_holder_signature_attachment' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages()
    {
        return [];
    }
}
