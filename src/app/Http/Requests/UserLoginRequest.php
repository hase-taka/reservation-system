<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'email' => 'required|string|email|max:191',
            'password' => 'required|string|max:191|min:8',
        ];
    }

    public function messages(){
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メール形式で入力してください',
            'email.string' => '文字列で入力してください',
            'email.max' => '191字以下で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => '8字以上で入力してください',
            'password.max' => '191字以下で入力してください',
        ];
    }
}
