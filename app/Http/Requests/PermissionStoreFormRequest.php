<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionStoreFormRequest extends FormRequest
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
        }

        return [
            'name' => [
                'required',
                Rule::unique('permissions')->where(function ($query) use($name) {
                    return $query->where('name', $name);
                }),
            ],
            'slug' => [
                'required',
                Rule::unique('permissions')->where(function ($query) use($slug) {
                    return $query->where('slug', $slug);
                }),
            ]
        ];
    }
}
