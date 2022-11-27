<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreService extends FormRequest
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
            'client_id' => 'required',
            'city_id' => 'nullable|max:200',
            'destiny_id' => 'required|max:200',
            'type' => 'required',
            'description' => 'required|max:200|min:7',
            'photo' => 'required'
        ];
    }
}
