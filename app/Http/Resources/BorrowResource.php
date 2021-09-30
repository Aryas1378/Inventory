<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BorrowResource extends JsonResource
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
            'product' => ProductResource::make($this->whenLoaded('product')),
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'supervisor_permission' => $this->supervisor_permission,
        ];
    }
}
