<?php

namespace App\Http\Requests\Expense;

use App\Models\Colocation;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class storeExpenseRequest extends FormRequest
{

    protected ?string $message= null;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $colocationId= $this->input('colocation_id');
        $colocation= Colocation::find($colocationId);

        if (!$colocation) 
        {
            $this->message = 'Colocation not found.';
            return false;
        }
        
        $response = Gate::inspect('create', [\App\Models\Expense::class, $colocation]);
        $this->message= $response->message();

        return $response->allowed();
    }

    public function failedAuthorization()
    {
        $redirect = redirect()->back()->with('access denied', $this->message);

        $exception= throw new AuthorizationException($this->message);

        $exception->withResponse($redirect);

        return $exception;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'colocation_id' => 'required|exists:colocations,id',
            'payer_id' => 'nullable|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'A title is required for the expense.',
            'amount.required' => 'An amount is required.',
            'category_id.exists' => 'The selected category is invalid.',
            'colocation_id.exists' => 'The selected colocation is invalid.',
        ];
    }
}
