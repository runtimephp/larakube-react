<?php

declare(strict_types=1);

namespace App\Http\Requests\Organizations;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

use function abort;
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
                ->belongsToOrganization(
                    request()->string('slug')->toString()
                )
            : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug' => ['required', 'string', 'exists:organizations,slug', 'min:5', 'max:255'],
            'routeName' => ['required', 'string'],
        ];
    }

    protected function failedAuthorization(): void
    {
        abort(Response::HTTP_NOT_FOUND);
    }
}
