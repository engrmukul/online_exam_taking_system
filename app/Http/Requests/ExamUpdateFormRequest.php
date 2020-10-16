<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExamUpdateFormRequest extends FormRequest
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
            'subject_id' =>  'required',
            'exam_title' =>  'required',
            'exam_date' =>  'required',
            'noq' =>  'required|numeric',
            'start_time' =>  'required',
            'end_time' =>  'required',
            'exam_status' =>  'required',
        ];
    }
}
