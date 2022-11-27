<?php

namespace App\Http\Resources;

use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'id' => $this->id,
            'client_id' => $this->client_id,
            'city_id' => $this->city_id,
            'destiny_id' => $this->destiny_id,
            'type' => $this->type,
            'description' => $this->description,
            'photo' => $this->photo,
            'status' => $this->status
        ];
    }
}
