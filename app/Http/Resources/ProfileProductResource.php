<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileProductResource extends JsonResource
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
            'code' => $this->code,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'submit' => $this->submit,
            'status' => new StatusResource($this->status),
            'product' => ProductResource::make($this->whenLoaded('product')),
        ];
    }
}
