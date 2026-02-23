<?php

namespace App\Http\Requests;

use App\Models\Colocation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreColocationRequest extends FormRequest
{
    protected ?string $message = null;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $response = Gate::inspect('create', Colocation::class);
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

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'categories' => 'required|array|min:1',
            'categories.*.name' => 'required|string|max:255',
        ];
    }
}
