<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        $regPhoneNumber = "/^[\+]?3?[\s]?8?[\s]?\(?0\d{2}?\)?[\s]?\d{3}[\s|-]?\d{2}[\s|-]?\d{2}$/";


        return [
            'name' => ['bail', 'required', 'max:30', 'min:2'],
            'surname' => ['bail', 'required', 'max:70', 'min:3'],
            'email' => ['bail','required', 'email', 'max:255',],
            'phone' =>['bail','required','min:13','max:13',"regex:{$regPhoneNumber}",],
            'city' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:100'],
        ];
    }

    public function all($keys = null) {
        if(empty($keys)) {
            return parent::json()->all();
        }

        return $this->collect(parent::json()->all())->only($keys)->toArray();
    }
}
