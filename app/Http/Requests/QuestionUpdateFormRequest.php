<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionUpdateFormRequest extends FormRequest
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
        if ($this->request->has('question')){
            $question = $this->question;
            $questiontId = $this->id;
        }

        return [
            'subject_id' =>  'required',
            'question' => [
                'required',
                Rule::unique('questions')->where(function ($query) use($question, $questiontId) {
                    return $query->where('question', $question)->where('id', '<>', $questiontId);
                }),
            ]
        ];
    }
}
