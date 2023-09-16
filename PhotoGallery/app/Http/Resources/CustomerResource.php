<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $orders = $this->order()->get();
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "email" => $this->user->email,
            "name" => $this->user->name,
            "phone" => $this->phone,
            "address" => $this->address,
            "orders" => $orders,
        ];
    }
}
