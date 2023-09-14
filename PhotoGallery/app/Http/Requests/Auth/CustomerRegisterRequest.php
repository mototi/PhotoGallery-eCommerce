<?php

namespace App\Http\Requests\Auth;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRegisterRequest extends FormRequest
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
            "first_name" => ["required", "string", "max:50"],
            "last_name" => ["required" , "string" , "max:50"],
            "phone" => ["required" , "string" , "max:50"],
            "email" => ["required", "string", "email", "unique:users"],
            "address" => ["required", "string", "max:255"],
            "password" => ["required", "string"],
        ];
    }

     /**
     * Register a new user.
     */
    public function registerUser() : User
    {
        try {
            //begin transaction
            DB::beginTransaction();

            //create new user
            $user = User::create([
                "name" => trim($this->first_name . " " . $this->last_name),
                "email" => $this->email,
                "password" => Hash::make($this->password),
            ]);

            //create new customer
            Customer::create([
                "first_name" => $this->first_name,
                "last_name" => $this->last_name,
                "user_id" => $user->id,
                "address" => $this->address,
                "phone" => $this->phone,
            ]);

            DB::commit();
            return $user;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
