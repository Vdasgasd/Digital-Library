<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBooksRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'pages' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'pdf_file' => 'required|mimes:pdf',
            'cover_image' => 'required|image|mimes:jpeg,jpg,png|max:2048', // JPEG, JPG, PNG image, maximum size 2MB
        ];
    }
    public function messages()
    {
        return [
            'pdf_file.required' => 'The PDF file is required.',
            'pdf_file.mimes' => 'The PDF file must be a valid PDF document.',
            'cover_image.required' => 'The cover image is required.',
            'cover_image.image' => 'The cover image must be a valid image file.',
            'cover_image.mimes' => 'The cover image must be in JPEG, JPG, or PNG format.',
            'cover_image.max' => 'The cover image must not exceed 2 MB in size.',
        ];
    }
}
