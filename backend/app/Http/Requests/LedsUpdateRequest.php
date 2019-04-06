<?php

namespace App\Http\Requests;

use App\Leds;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LedsUpdateRequest extends FormRequest
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
            'brightness' => ['numeric', 'between:0,100'],
            'mode' => [Rule::in(Leds::MODES)],
            'change_rate' => ['numeric', 'between:0,100'],
            'color' => ['json'],

            'colors.red' => ['required_with:color', 'between:0,255'],
            'colors.green' => ['required_with:color', 'between:0,255'],
            'colors.blue' => ['required_with:color', 'between:0,255'],
        ];
    }
}
