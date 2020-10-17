<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionAssignStoreFormRequest extends FormRequest
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
        if ($this->request->has('exam_id')){
            $examId = $this->exam_id;
        }

        return [
            'exam_id' => 'required',
            'student_id' => [
                'required',
                Rule::unique('question_assigns')->where(function ($query) use($examId) {
                    return $query->where('exam_id', $examId);
                }),
            ],
        ];
    }
}
