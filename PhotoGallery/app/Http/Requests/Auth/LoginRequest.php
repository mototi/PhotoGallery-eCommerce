<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "email" => ["required", "email" , "exists:users,email"],
            "password" => ["required", "string"],
        ];
    }

    /**
     * return token when user is authenticated
     */

    public function authenticated() : array
    {
        $credentioals = $this->only('email', 'password');
        try{
            // check credentials
            $auth = auth()->attempt($credentioals);
            if(!$auth){
                return [
                    "success" => false,
                    "message" => "Invalid credentials"
                ];
            }

            // generate token
            $token = auth()->user()->createToken('auth_token')->plainTextToken;

            // create new cart if the login is customer
            if(auth()->user()->isCustomer()){
                // delete all carts that has total price 0
                auth()->user()->customer->cart()->where('total_price', 0)->delete();
                // create new cart
                auth()->user()->customer->cart()->create([
                    'total_price' => 0
                ]);
            }

            return [
                "success" => true,
                "token" => $token
            ];

        }catch(\Exception $e){
            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }
}
