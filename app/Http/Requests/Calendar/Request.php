<?php

namespace App\Http\Requests\Calendar;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Request extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'email'],
            'date' => ['required', 'date', 'after:yesterday'],
            'time' => ['required','date_format:h:i A'],
            'g-recaptcha-response' => 'required|captcha',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'phone.required' => 'Phone is required',
            'email.required' => 'Email is required',
            'date.required' => 'Date is required',
            'time.required' => 'Time is required',
        ];
    }
}
