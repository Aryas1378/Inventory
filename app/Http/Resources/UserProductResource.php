<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProductResource extends JsonResource
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
            'user' => UserResource::make($this->whenLoaded('user')),
            'submit' => $this->submit,
            'product' => ProductResource::make($this->whenLoaded('product')),
            'code' => $this->code,
            'from_date' => $this->from_date,
            'status' => StatusResource::make($this->whenLoaded('status')),
        ];

    }
}
