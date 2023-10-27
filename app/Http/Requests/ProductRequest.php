<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'min:3|max:255|unique:products|required',
            'description' => 'min:3|max:10000|required',
            'link' => 'required|min:5|max:10000',
            'amount' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required'
        ];

        if ($this->method() === 'PUT') {
            $rules['name'] = [
                Rule::unique('products')->ignore($this->id)
            ];
            
            $rules['image'] =['nullable'];
        }
        return $rules;
    }
}
