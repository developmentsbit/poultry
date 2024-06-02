<?php

namespace App\Http\Requests;

use App\Rules\PlacementRule;
use Illuminate\Foundation\Http\FormRequest;

class MemberUpdateRequest extends FormRequest
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
            'email' => 'nullable|email',
            'mobile' => 'nullable',
            'password' => 'nullable|same:confirm_password',
        ];
    }

    public function attributes()
    {
        return [

        ];
    }

}