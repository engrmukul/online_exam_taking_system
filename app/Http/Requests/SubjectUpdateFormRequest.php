<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectUpdateFormRequest extends FormRequest
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
            $subjectId = $this->id;
        }

        return [
            'name' =>  'required',
            'code' => [
                'required',
                Rule::unique('subjects')->where(function ($query) use($code, $subjectId) {
                    return $query->where('code', $code)->where('id', '<>', $subjectId);
                }),
            ]
        ];
    }
}
