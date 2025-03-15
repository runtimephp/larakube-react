<?php

declare(strict_types=1);

namespace App\Http\Requests\CloudAccounts;

use App\Enums\CloudProvider;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function App\Support\Organization\organization;

final class StoreCloudAccountRequest extends FormRequest
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
            'provider' => ['required', 'string', Rule::enum(CloudProvider::class)],
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('cloud_accounts', 'name')
                    ->where(fn (Builder $query) => $query
                        ->where('organization_id', organization()?->id)
                        ->where('provider', $this->string('provider')->toString())
                    ),
            ],
            'key' => ['required', 'string', 'min:3', 'max:255'],
        ];
    }
}
