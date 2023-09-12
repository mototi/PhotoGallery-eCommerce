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

            return [
                "success" => true,
                "token" => $token
            ];

        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
