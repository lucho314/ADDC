<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentoFormRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'nro_plano' => 'required|integer|min:1',
            'nro_plano_hasta' => 'required|integer|min:1',
            'nro_dpto' => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17',
            'tipo_doc' => 'required',
            'nro_partida' => 'required|integer|min:0',
        ];
    }

}
