<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumberValidator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
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
        $request = request();
        $rules = [
            'full_name' => ['required', 'string'],
            'email' => ['nullable', 'email:rfc,dns'],
            'phone' => ['required', 'numeric', 'digits_between:10,15',
                new PhoneNumberValidator($request->country_code),
                Rule::unique('contacts')->where(function ($q) use ($request) {
                    return $q->where('dial_code', $request->dial_code)
                        ->where('phone', $request->phone);
                })->ignore($this->id)],
        ];
        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        // $this->validator = $validator; this is needed if want to control error from controller.
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => true,
        ], 422));

    }
}
