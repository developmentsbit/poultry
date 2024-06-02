<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|min:1',
            'email' => 'required|email|unique:users,email,'.@$this->user->id,
            'mobile' => 'nullable|unique:users,mobile,'.@$this->user->id,
            'dob' => 'nullable|date_format:d-m-Y',
            'image_remote_url' => 'required',
            'role_id' => 'required|integer|min:1',
        ];
    }

    public function attributes(){
        return [
            'image_remote_url' => 'Profile Image field is reuired'
        ];
    }

}
