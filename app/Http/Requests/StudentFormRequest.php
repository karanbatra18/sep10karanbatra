<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentFormRequest extends FormRequest
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
        $rules = [
            'name' => [
                'required',
                'string',
                'max:191',
            ],
            'email' => [
                'required',
                'email',
                'max:191',
                'unique:students,email',
            ],
            'phone' => [
                'required',
                'digits:10',
            ],
            'address' => [
                'required',
                'string',
                'max:191',
            ],
            'city' => [
                'required',
                'string',
                'max:191',
            ],
            'state' => [
                'required',
                'string',
                'max:191',
            ],
            'country' => [
                'required',
                'string',
                'max:191',
            ],
        ];

        return $rules;
    }
}
