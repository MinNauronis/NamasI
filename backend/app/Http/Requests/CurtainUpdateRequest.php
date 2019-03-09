<?php

namespace App\Http\Requests;

use App\Curtain;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CurtainUpdateRequest extends FormRequest
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
            'title' => ['string', 'max:144'],
            'micro_controller_id' => [
                'nullable',
                'regex:/^[0-2][0-5][0-5].[0-2][0-5][0-5].[0-2][0-5][0-5].[0-2][0-5][0-5]$/'
            ],
            'is_close' => ['boolean'],
            'is_activated' => ['boolean'],
            'mode' => Rule::in(Curtain::MODES),
            'select_schedule_id' => ['nullable', 'numeric'],
        ];
    }
}
