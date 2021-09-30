<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'id' => $this->id,
            'name' => $this->name,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'brand' => BrandResource::make($this->whenLoaded('brand')),
            'status' => StatusResource::make($this->whenLoaded('status')),
        ];
    }
}
