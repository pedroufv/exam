<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'statement' => 'required|string',
            'subject_id' => 'required|integer',
            'user_id' => 'required|integer',
            'contest_id' => 'nullable|integer',
        ];
    }
}
