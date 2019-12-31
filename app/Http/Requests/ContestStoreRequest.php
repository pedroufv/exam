<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContestStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'year' => 'required|string|max:4',
            'number' => 'required|integer',
            'institution_id' => 'required|integer',
            'applicator_id' => 'required|integer',
        ];
    }
}
