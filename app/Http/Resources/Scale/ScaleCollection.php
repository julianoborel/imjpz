<?php

namespace App\Http\Resources\Scale;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ScaleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'scales' => ScaleResource::collection($this->collection),
        ];
    }
}
