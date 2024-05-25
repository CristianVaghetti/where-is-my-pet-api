<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class ProfileRequest extends BaseRequest
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
            'name' => ['required', 'max:20'],
            'description' => ['required', 'max:100'],
            'type_id' => ['required', 'integer', 'min:1'],
            'status' => ['boolean'],
            'roles' => ['array', 'required'],
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
            'name' => 'nome',
            'description' => 'descrição'
        ];
    }
}
