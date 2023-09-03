<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $regPhoneNumber = "/^[\+]?3?[\s]?8?[\s]?\(?0\d{2}?\)?[\s]?\d{3}[\s|-]?\d{2}[\s|-]?\d{2}$/";

        return [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'surname' => ['bail', 'required', 'max:70', 'min:3'],
            'phone' =>['bail','required','min:13','max:13',"regex:{$regPhoneNumber}",'unique:users',],
            'birthdate' => ['bail', 'required', 'date', 'before_or_equal:-18 years'],

        ];
    }
}
