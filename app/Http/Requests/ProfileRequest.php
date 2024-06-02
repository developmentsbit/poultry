<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'user_id' => 'required|integer|min:1',
            'name' => 'required|string|min:1',
            'email' => 'required|email|unique:users,email,' . @request()->user_id,
            'mobile' => 'nullable',
            'dob' => 'nullable|date_format:d-m-Y',
            'image' => 'nullable|mimes:png,jpg,jpeg,gif,bmp,webp|min:10|max:5120',
        ];
    }

}