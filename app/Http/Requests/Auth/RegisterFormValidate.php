<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;


class RegisterFormValidate extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            'email' => ['bail','required', 'email', 'max:255', 'unique:users'],
            'phone' =>['bail','required','min:13','max:13',"regex:{$regPhoneNumber}",'unique:users',],
            'birthdate' => ['bail', 'required', 'date', 'before_or_equal:-18 years'],
            'password' => ['bail','required', 'confirmed', 'min:5', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле обязательно для заполнения',
            'name.string' => 'Имя должно быть в строковом формате',
            'name.max' => 'Максимальная длина 30 символов',
            'name.min' => 'Минимальная длина 2 символа',

            'surname.required' => 'Поле обязательно для заполнения',
            'surname.string' => 'Фамилия должна быть в строковом формате',
            'surname.max' => 'Максимальная длина 70 символов',
            'surname.min' => 'Минимальная длина 3 символа',

            'email.required' => 'Поле обязательно для заполнения',
            'email.email' => 'Введите правильный email',
            'email.max' => 'Максимальная длина 255 символов',
            'email.unique' => 'Такой email уже существует',

            'phone.required' => 'Поле обязательно для заполнения',
            'phone.max' => 'Длина телефона должна быть 13 символов',
            'phone.min' => 'Длина телефона должна быть 13 символов',
            'phone.regex' => 'Введите номер в формате +380',
            'phone.unique' => 'Такой номер уже существует',

            'birthdate.required' => 'Поле обязательно для заполнения',
            'birthdate.date' => 'Введите правильно дату',
            'birthdate.before_or_equal' => 'Вам должно быть больше 18 лет',

            'password.required' => 'Поле обязательно для заполнения',
            'password.min' => 'Минимальная длина пароля 5 символов',
            'password.max' => 'Максимальная длина пароля 255 символов',
            'password.confirmed' => 'Пароль подтверждения не совпадает',
        ];
    }
}
