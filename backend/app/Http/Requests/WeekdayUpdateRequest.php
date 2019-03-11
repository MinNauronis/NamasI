<?php

namespace App\Http\Requests;

use App\Weekday;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WeekdayUpdateRequest extends FormRequest
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
            'weekday' => ['numeric', 'between:0,6'],
            'mode' => Rule::in(Weekday::MODES),
            'openTime' => ['nullable', 'date_format:"H:i:s"'],
            'closeTime' => ['nullable', 'date_format:"H:i:s"'],

        ];
    }
}
