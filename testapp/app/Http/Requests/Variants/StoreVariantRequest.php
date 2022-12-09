<?php

namespace App\Http\Requests\Variants;

use Illuminate\Foundation\Http\FormRequest;

class StoreVariantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'question_id' => 'required,exists:App\Models\Question,id',
            'title' => 'required|string',
            'weight' => 'required|numeric',
            'is_published' => 'required|bool',
        ];
    }
}
