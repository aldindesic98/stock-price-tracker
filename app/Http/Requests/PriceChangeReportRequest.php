<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PriceChangeReportRequest extends FormRequest
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
            'startDateTime' => 'required|date',
            'endDateTime' => 'required|date|after:startDateTime',
        ];
    }

    public function messages(): array
    {
        return [
            'stock_ids.required' => 'PRICE-CHANGE-REPORT-0001',
            'stock_ids.array' => 'PRICE-CHANGE-REPORT-0002',
            'stock_ids.*.integer' => 'PRICE-CHANGE-REPORT-0003',
            'stock_ids.*.exists' => 'PRICE-CHANGE-REPORT-0004',
            'startDateTime.required' => 'PRICE-CHANGE-REPORT-0005',
            'startDateTime.date' => 'PRICE-CHANGE-REPORT-0006',
            'endDateTime.required' => 'PRICE-CHANGE-REPORT-0007',
            'endDateTime.date' => 'PRICE-CHANGE-REPORT-0008',
            'endDateTime.after' => 'PRICE-CHANGE-REPORT-0009',
        ];
    }
}
