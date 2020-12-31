<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'name' => 'required|string',
            'surname' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed|required_with:old_password',
            'new_photo' => 'nullable|mimes:jpeg,jpg,png',
        ];
    }
}
