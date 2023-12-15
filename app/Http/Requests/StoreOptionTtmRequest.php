<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;

class StoreOptionTtmRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $ancienMax = DB::table('option_ttms')->max('maxComplexite') ?? 0;
        return [
            'nom'=>['required','unique:option_ttms,"nom"'],
            'minComplexite'=> 'required|numeric|min:' . ($ancienMax),
            'maxComplexite'=> 'required|numeric',
            'jalons' => 'array',
            'jalons.*' => 'exists:jalons,id',
        ];
    }
}
