<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubCategoryResource;

class CategoryResource extends JsonResource
{
    public static function collection($resource)
    {
        return tap(new categoryResourceCollection($resource), function ($collection) {
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
            "name"=>$this->name,
            "cover"=>url($this->cover),
            "subCategory" =>SubCategoryResource::collection($this->subCategories)->hide(['stores']),
        ]);
    }
}
