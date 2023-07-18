<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can(config('permission.access.products.publish'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:2', 'max:255', 'unique:' . Product::class],
            'description' => ['nullable', 'string', 'max:255'],
            'SKU' => ['required', 'string', 'min:1', 'max:35', 'unique:' . Product::class],
            'price' => ['required', 'numeric', 'min:1'],
            'discount' => ['required', 'numeric', 'min:0', 'max:99'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'categories.*' => ['nullable', 'numeric', 'exists:App\Models\Category,id']
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Поле обязательно для заполнения',
            'title.string' => 'Введите корректное название',
            'title.min' => 'Минимальная длина 2 символа',
            'title.max' => 'Максимальная длина 50 символов',
            'title.unique' => 'Такое название уже есть',

            'description.string' => 'Введите корректное описание',
            'description.max' => 'Максимальная длина 255 символов',

            'SKU.required' => 'Поле обязательно для заполнения',
            'SKU.min' => 'Минимальная длина 1 символ',
            'SKU.max' => 'Максимальная длина 35 символов',
            'SKU' => 'Такое SKU уже есть',

            'price.required' => 'Поле обязательно для заполнения',
            'price.min' => 'Минимальная длина 1 символ',
            'price.numeric' => 'Введите число',

            'discount.required' => 'Поле обязательно для заполнения',
            'discount.min' => 'Минимальный размер скидки 1%',
            'discount.max' => 'Максимальный размер скидки 99%',
            'discount.numeric' => 'Введите число',

            'quantity.required' => 'Поле обязательно для заполнения',
            'quantity.min' => 'Введите кол-во товара',
            'quantity.numeric' => 'Введите число',

            'categories.numeric' => 'Ошибка',
            'categories.exists' => 'Ошибка',
        ];
    }
}
