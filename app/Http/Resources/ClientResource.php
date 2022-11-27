<?php

namespace App\Http\Resources;

use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'code'   => 200,
            'message'   => 'successful',
            "id" => $this->id,
            "user_id" => $this->user_id,
            "name" => Str::upper($this->name),
            "lastname" => Str::upper($this->lastname),
            "identification_card" => $this->identification_card,
            "phone" => $this->phone,
            "address" => $this->address,
            "email" => User::find($this->user_id)->email,
            "country_id" => $this->country_id,
            "country" => Country::find($this->country_id)->name
        ];
    }
}
