<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'icon' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'ชื่อหมวดหมู่เป็นสิ่งจำเป็น',
            'name.unique' => 'ชื่อหมวดหมู่นี้มีอยู่แล้ว',
            'image.image' => 'ไฟล์ต้องเป็นรูปภาพ',
            'image.mimes' => 'รูปภาพต้องเป็นไฟล์ jpeg, png, jpg หรือ gif',
            'image.max' => 'ขนาดรูปภาพต้องไม่เกิน 2MB',
        ];
    }
}
