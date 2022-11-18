<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
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
            'title'             => Rule::unique('companies', 'title')->ignore($this->route("company.id")),
            'description'       => 'required',
            'logo'              => 'nullable|mimes:jpeg,jpg,png,gif',
            'industry'          => 'nullable',
        ];
    }
}
