<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class ShelterRequest extends BaseRequest
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
            'name' => ['required', 'string', 'max:255'],
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'zip_code' => ['string', 'min:8', 'max:8'],
            'district' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'address_number' => ['required', 'string', 'max:255'],
            'address_note' => ['string', 'nullable', 'max:255'],
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
            'state_id' => 'Estado',
            'city_id' => 'Cidade',
            'zip-code' => 'CEP',
            'district' => 'Bairro',
            'address' => 'Logradouro',
            'address_number' => 'Número',
            'address_note' => 'Complemento',
        ];
    }
}
