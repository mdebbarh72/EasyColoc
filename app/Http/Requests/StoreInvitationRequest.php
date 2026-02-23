<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Invitation;
use Illuminate\Support\Facades\Gate;

class StoreInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    protected ?string $message = null;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $response = Gate::inspect('create', Invitation::class);
        $this->message = $response->message();
        return $response->allowed();
    }

    /**
     * Handle a failed authorization attempt.
     */
    protected function failedAuthorization()
    {
        $redirect = redirect()->back()->with('error', $this->message ?: 'Unauthorized.');
        
        $exception = new \Illuminate\Auth\Access\AuthorizationException($this->message ?: 'Unauthorized.');
        $exception->withResponse($redirect);
        
        throw $exception;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['nullable', 'email', 'max:255'],
            'colocation_id' => ['required', 'exists:colocations,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'We need the email address to send the invitation.',
            'email.email' => 'Please provide a valid email address.',
            'colocation_id.required' => 'The colocation reference is missing.',
            'colocation_id.exists' => 'The selected colocation does not exist.',
        ];
    }
}
