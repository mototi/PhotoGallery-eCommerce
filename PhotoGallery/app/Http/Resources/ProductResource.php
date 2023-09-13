<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $image_name = $this->image;
        $path = public_path() . "/images/products/" . $image_name;

        return [
            "id" => $this->id,
            "admin_id" => new AdminResource ($this-> whenLoaded('admin')),
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price,
            "image" => $path,
            "category" => $this->category,
            "stock" => $this->stock,
        ];
    }
}
