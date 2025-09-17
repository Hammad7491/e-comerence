<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => ['required','string','max:255'],
            'description'    => ['nullable','string'],
            'final_price'    => ['required','numeric','min:0'],
            'original_price' => ['nullable','numeric','min:0'],
            'stock'          => ['required','integer','min:0'],
            'is_active'      => ['nullable','boolean'],

            'pieces'         => ['required','in:2-piece,3-piece'],
            'collection'     => ['required','in:summer,winter,spring'],

            'images'         => ['nullable','array','max:3'],
            'images.*'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],

            'remove_images'  => ['nullable','array'],
            'remove_images.*'=> ['string'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => (bool) $this->boolean('is_active'),
        ]);
    }
}
