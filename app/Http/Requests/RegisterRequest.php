<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => ['required', Rule::in([User::ROLE_SCHOOL, User::ROLE_TEACHER, User::ROLE_STUDENT]),],
            'token' => 'nullable'
        ];
    }
}
