<?php

namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;

class DeleteExpenseRequest extends FormRequest
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
        $expense = $this->route('expense');
        // Fallback or explicit Gate inspection
        $response = \Illuminate\Support\Facades\Gate::inspect('delete', $expense);
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
            //
        ];
    }
}
