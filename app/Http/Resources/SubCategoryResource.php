<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
{
    public static function collection($resource)
    {
        return tap(new subcategoryResourceCollection($resource), function ($collection) {
            $collection->collects = __CLASS__;
        });
    }
    protected $withoutFields = [];

    public function hide(array $fields)
    {
        $this->withoutFields = $fields;
        return $this;
    }

    protected function filterFields($array)
    {
        return collect($array)->forget($this->withoutFields)->toArray();
    }
    public function toArray($request)
    {
        return $this->filterFields([
            "id"=>$this->id,
            "sub_name"=>$this->sub_name,
            "cover"=>url($this->cover) ,
            "stores"=>StoreResource::collection($this->stores)            
        ]);
    }
}
