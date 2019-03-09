<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurtainStoreRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:144'],
            'micro_controller_id' => [
                'required',
                'nullable',
                'regex:/^[0-2][0-5][0-5].[0-2][0-5][0-5].[0-2][0-5][0-5].[0-2][0-5][0-5]$/'
            ],
            'is_activated' => ['required', 'boolean'],
        ];
    }
}
