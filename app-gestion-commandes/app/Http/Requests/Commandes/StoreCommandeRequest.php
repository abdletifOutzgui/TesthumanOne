<?php

namespace App\Http\Requests\Commandes;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommandeRequest extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'produits' => 'required|array',
            'quantites' => 'required|array',
            'produits.*' => 'required|exists:produits,id',
            'quantites.*' => 'integer|min:1',
            'prix_*' => 'sometimes|numeric',
        ];
    }
}
