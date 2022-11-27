<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreClient extends FormRequest
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
            'email' => 'required|unique:users|max:100',
            'password' => 'required|min:7|max:20'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'code'   => 401,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()

        ]));
    }

    public function messages()
    {
        return [
            'country_id' => 'country_id is required',
            'name' => 'name is required',
            'lastname' => 'lastname is required',
            'identification_card' => 'identification_card is required',
            'phone' => 'phone is required',
            'address' => 'address is required',
            'email' => 'email is required',
            'email.unique' => 'The email you entered already exist',
            'password' => 'password is required',
        ];
    }
}
