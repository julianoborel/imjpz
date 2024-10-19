<?php

namespace App\Http\Resources\Scale;

use App\Http\Resources\Minister\MinisterResource;
use App\Http\Resources\Music\MusicResource;
use App\Http\Resources\BackingVocal\BackingVocalResource; // Assegure-se de que essa resource exista
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ScaleResource extends JsonResource
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
            "id" => $this->id,
            "date" => $this->date,
            "description" => $this->description,
            "users" => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
