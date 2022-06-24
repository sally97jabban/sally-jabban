<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ColorResource;
use App\Http\Resources\SizeResource;
class ProductResource extends JsonResource
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
            "id"=>$this->id,
            "name"=>$this->name,
            "price"=>$this->price,
            "discount"=>$this->discount,
            "description"=>$this->description,
            "color"=>$this->color,
            "size"=>$this->size,
            "image"=>url($this->image),
            "color"=>ColorResource::collection($this->colors),
            "size"=>SizeResource::collection($this->sizes)
        ];
    }
}
