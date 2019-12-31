<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OptionUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'statement' => 'required|string',
            'correct' => 'required',
            'question_id' => 'required|integer',
        ];
    }
}
