<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateFormRequest extends FormRequest
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
            $userId = $this->id;
        }

        return [
            'name' => 'required',
            'mobile' => 'required',
            'username' => [
                'required',
                Rule::unique('users')->where(function ($query) use($username, $userId) {
                    return $query->where('username', $username)->where('id', '<>', $userId);
                }),
            ],
            'email' => [
                'required',
                Rule::unique('users')->where(function ($query) use($email, $userId) {
                    return $query->where('email', $email)->where('id', '<>', $userId);
                }),
            ],
            'password' => 'required',
        ];
    }
}
