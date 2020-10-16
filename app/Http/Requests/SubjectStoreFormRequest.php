<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectStoreFormRequest extends FormRequest
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
        if ($this->request->has('code')){
            $code = $this->code;
        }

        return [
            'name' =>  'required',
            'code' => [
                'required',
                Rule::unique('subjects')->where(function ($query) use($code) {
                    return $query->where('code', $code);
                }),
            ]
        ];
    }
}
