<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleUpdateFormRequest extends FormRequest
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
        if ($this->request->has('name')){
            $name = $this->name;
            $slug = $this->slug;
            $roleId = $this->id;
        }

        return [
            'name' => [
                'required',
                Rule::unique('roles')->where(function ($query) use($name, $roleId) {
                    return $query->where('name', $name)->where('id', '<>', $roleId);
                }),
            ],
            'slug' => [
                'required',
                Rule::unique('roles')->where(function ($query) use($slug, $roleId) {
                    return $query->where('slug', $slug)->where('id', '<>', $roleId);
                }),
            ]
        ];
    }
}
