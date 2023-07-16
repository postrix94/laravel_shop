<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can(config('permission.access.categories.publish'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:50', "unique:categories"],
            'description' => ['nullable', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:App\Models\Category,id']

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле обязательно для заполнения',
            'name.string' => 'Введите корректное название',
            'name.min' => 'Минимальная длина 2 символа',
            'name.max' => 'Максимальная длина 50 символов',
            'name.unique' => 'Такое название уже есть',

            'description.string' => 'Введите корректное описание',
            'description.max' => 'Максимальная длина 255 символов',

            'parent_id.exists' => 'Такого родителя не существует',
        ];
    }
}
