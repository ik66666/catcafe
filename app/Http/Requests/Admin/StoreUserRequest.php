<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','email','unique:users','max:255'],
            'password' => ['required','string','min:8','confirmed'],
            'image' => ['required',
            'file',
            'image',
            'max:2000',
            'mimes:jpeg,jpg,png',
            'dimensions:min_width=100,min_height=100,max_width=700,max_height=600'],
            'introduction' => ['required','string','max:255'],
        ];
    }

    public function attributes()
    {
        return [
            'introduction' => '自己紹介文',
            'password' => 'パスワード',
            'image' => '画像',
        ];
    }
}
