<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class UserRequest extends BaseRequest
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
            'name' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:16'],
            'phone' => ['required', 'string', 'min:10', 'max:11'],
            'email' => ['string', 'max:50'],
            'status' => ['boolean'],
            'profile_id' => ['required', 'integer', 'exists:profiles,id'],
            'avatar' => ['string', 'nullable'],
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
            'name' => 'Nome',
            'username' => 'Usuário',
            'phone' => 'Contato',
            'email' => 'Email',
            'status' => 'Status',
            'profile_id' => 'Perfil',
            'avatar' => 'Imagem de perfil',
        ];
    }
}
