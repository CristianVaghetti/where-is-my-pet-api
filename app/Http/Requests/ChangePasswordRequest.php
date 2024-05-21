<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class ChangePasswordRequest extends BaseRequest
{

    /**
     * Response message
     *
     * @var string
     */
    protected $responseMessage = "Dados inválidos. Tente novamente!";

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required',
            'new_password' => 'required',
            'new_password_confirmation' => 'required',
        ];
    }

    /**
     * Specific validations messages
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'password' => 'Senha',
            'new_password' => 'Nova senha',
            'new_password_confirmation' => 'Confirmação de nova senha',
        ];
    }
}
