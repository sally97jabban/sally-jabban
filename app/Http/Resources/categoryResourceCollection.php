<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class categoryResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    protected $withoutFields = [];
    public function toArray($request)
    {
        return $this->processCollection($request);
    }
    public function hide(array $fields)
    {
        $this->withoutFields = $fields;
        return $this;
    }
    protected function processCollection($request)
    {
        return $this->collection->map(function (CategoryResource $resource) use ($request) {
            return $resource->hide($this->withoutFields)->toArray($request);
        })->all();
    }

}
