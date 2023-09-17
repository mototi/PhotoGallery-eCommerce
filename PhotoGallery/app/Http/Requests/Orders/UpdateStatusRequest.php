<?php

namespace App\Http\Requests\Orders;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "order_id" => "required|exists:orders,id",
            "status" => "required|in:on it,shipped,delieverd,canceled",
        ];
    }

    //update order status
    public function updateOrder()
    {
        $order = Order::find($this->order_id);

        $order->update([
            'status' => $this->status,
        ]);

        return $order;
    }
}
