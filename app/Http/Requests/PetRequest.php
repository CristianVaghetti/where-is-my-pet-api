<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class PetRequest extends BaseRequest
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
            'personality' => ['required', 'string', 'max:255'],
            'file' => ['required', 'string'],
            'shelter_id' => ['required', 'integer', 'exists:shelters,id'],
            'found' => ['boolean'],
            'owner_name' => ['string', 'nullable', 'max:255'],
            'owner_email' => ['email', 'nullable', 'max:255'],
            'owner_phone' => ['string', 'nullable', 'max:255'],
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
            'personality' => 'Personalidade',
            'photo' => 'Foto',
            'shelter_id' => 'Abrigo',
            'found' => 'Encontrado',
            'owner_name' => 'Nome do dono',
            'owner_email' => 'Email do dono',
            'owner_phone' => 'Telefone do dono',
        ];
    }
}
