<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StockSetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'stock_ids' => 'required|array',
            'stock_ids.*' => 'integer|exists:stock_prices,id',
        ];
    }

    public function messages(): array
    {
        return [
            'stock_ids.required' => 'STOCK-SET-0001',
            'stock_ids.array' => 'STOCK-SET-0002',
            'stock_ids.*.integer' => 'STOCK-SET-0003',
            'stock_ids.*.exists' => 'STOCK-SET-0004',
        ];
    }
}
