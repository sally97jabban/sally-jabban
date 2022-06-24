<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request){
    return [
        "id"=>$this->id,
        "name"=>$this->name,
        "description"=>$this->description,
        "location"=>$this->location,
        "description"=>$this->description,
        "store_image"=>url($this->image),
        "open_state" =>$this->open_state,
        "latitude"=>$this->latitude,
        "longitude"=>$this->longitude,
    ];
}
}
