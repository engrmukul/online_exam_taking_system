<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionUpdateFormRequest extends FormRequest
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
            $permissionId = $this->id;
        }

        return [
            'name' => [
                'required',
                Rule::unique('permissions')->where(function ($query) use($name, $permissionId) {
                    return $query->where('name', $name)->where('id', '<>', $permissionId);
                }),
            ],
            'slug' => [
                'required',
                Rule::unique('permissions')->where(function ($query) use($slug, $permissionId) {
                    return $query->where('slug', $slug)->where('id', '<>', $permissionId);
                }),
            ]
        ];
    }
}
