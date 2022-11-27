<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClient extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'country_id' => 'required',
            'name' => 'required|max:200',
            'lastname' => 'required|max:200',
            'identification_card' => 'required|max:20',
            'phone' => 'required|max:20|min:7',
            'address' => 'required|max:200',
            'email' => 'required|unique:users|max:100'
        ];
    }
}
