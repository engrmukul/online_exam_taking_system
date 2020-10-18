<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreFormRequest extends FormRequest
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
        if ($this->request->has('username')){
            $username = $this->username;
            $email = $this->email;
        }

        return [
            'name' => 'required',
            'mobile' => 'required',
            'username' => [
                'required',
                Rule::unique('users')->where(function ($query) use($username) {
                    return $query->where('username', $username);
                }),
            ],
            'email' => [
                'required',
                Rule::unique('users')->where(function ($query) use($email) {
                    return $query->where('email', $email);
                }),
            ],
            'password' => 'required',
        ];
    }
}
