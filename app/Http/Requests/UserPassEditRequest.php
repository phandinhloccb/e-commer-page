<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PasswordRule;

class UserPassEditRequest extends FormRequest
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
            'oldpassword' => 'required|min:8|max:255',
            'password' => ['required', 'min:8', 'max:64'],
            'password_confirmation' => ['required', 'min:8', 'max:64', 'same:password'],
        ];
    }

        /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'oldpassword' => '現在のパスワード',
            'password' => '変更するパスワード',
            'password_confirmation' => 'パスワードの確認'
        ];
    }
}
