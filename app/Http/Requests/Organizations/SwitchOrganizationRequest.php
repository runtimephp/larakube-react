<?php

declare(strict_types=1);

namespace App\Http\Requests\Organizations;

use Illuminate\Foundation\Http\FormRequest;

use function request;

final class SwitchOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        return $this->user()
            ? $this->user()
                ->belongsToOrganization(request()->integer('organizationId'))
            : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'organizationId' => ['required', 'integer', 'exists:organizations,id'],
            'routeName' => ['required', 'string'],
        ];
    }
}
