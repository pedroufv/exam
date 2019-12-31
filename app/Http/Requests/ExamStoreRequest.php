<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => 'required|integer',
            'finished_at' => 'nullable|date_format:d/m/Y',
            'filters' => 'nullable|string',
            'user_id' => 'required|integer',
        ];
    }
}
