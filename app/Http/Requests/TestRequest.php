<?php

namespace App\Http\Requests;

use App\Education;
use App\MaritalStatus;
use App\Sex;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TestRequest extends FormRequest
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
            'sex' => [
                'required',
                'numeric',
                Rule::in(array_keys(Sex::all())),
            ],
            'education' => [
                'required',
                'numeric',
                Rule::in(array_keys(Education::all())),
            ],
            'marital_status' => [
                'required',
                'numeric',
                Rule::in(array_keys(MaritalStatus::all())),
            ],
            'age' => [
                'required',
                'numeric',
            ],
        ];

        for ($i = 1; $i <= 6; $i++) {
            $rules['payment_'.$i.'_late'] = [
                'required',
                'numeric',
            ];
        }

        return $rules;
    }
}
