<?php

declare(strict_types=1);

namespace App\Http\Requests\Clusters;

use App\Enums\Region;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreClusterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'region' => ['required', 'string', 'min:5', 'max:255', Rule::enum(Region::class)],
            'cloudAccountId' => ['required', 'integer', 'exists:cloud_accounts,id'],
        ];
    }
}
