<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can(config('permission.access.categories.edit'));;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $slug = $this->route('category');

        return [
            'name' => ['required', 'string', 'min:2', 'max:50', Rule::unique(Category::class, 'name')->ignore($slug, 'slug')],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', "exists:App\Models\Category,id"],
        ];
    }
}
