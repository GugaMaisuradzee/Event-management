<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string','max:255'],
            'description' => ['nullable','string'],
            'start_date' => ['nullable','date'],
            'end_date' => ['date','after:start_time']
        ];
    }
}
