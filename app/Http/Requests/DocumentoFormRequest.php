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
    public function rules($request=null) {
       $datos=(!empty($request))?$request:$this;
       //dd($datos->all());
        return [
            'gral.nro_dpto'=>'required|numeric|in:01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17',
            'gral.nro_plano'=>'required|numeric|min:1',
            'gral.nro_plano_hasta'=>'required|numeric|min:'.$datos->gral['nro_plano'].'|doc_unico:'.$datos->gral['nro_dpto'].','.$datos->gral['nro_plano'].','.$datos->gral['nro_plano_hasta'].','.(isset($datos->gral['id'])?$datos->gral['id']:0).','.$datos->gral['tipo_doc_id'].','.(isset($datos->gral['fecha_certificado'])?$datos->gral['fecha_certificado']:null),
            'gral.tipo_doc_id'=>'required',
            'gral.fecha_registro'=>'date|after:01/01/1930',
            'gral.fecha_certificado'=>'date|after:01/01/1930',
            'gral.inscripcion'=>'regex:/^[0-9]+\*?/',
            'gral.nro_matricula'=>'regex:/^[0-9]+\*?/',
            'especial.*.nro_plano'=>'regex:/^[0-9]+\*?/',
            'especial.*.nro_partida'=>'regex:/^[0-9]+\*?/',
            'especial.*.sup_terreno'=>'regex:/^[0-9]+\*?/',
            'especial.*.sup_edificada'=>'regex:/^[0-9]+\*?/',
            'plano_ant.*'=>'numeric'
        ];
    }
    
public function attributes(){
        return [
            
            'gral.nro_dpto'=>'departamento',
            'gral.nro_plano'=>'número de plano',
            'gral.nro_plano_hasta'=>'número de plano hasta',
            'gral.tipo_doc_id'=>'tipo de documento',
            'gral.fecha_registro'=>'fecha de registro',
            'gral.inscripcion'=>'fecha de inscripción',
            'gral.nro_matricula'=>'número de matrícula',
            'especial.*.nro_plano'=>'número de plano',
            'especial.*.nro_partida'=>'número de partida',
            'especial.*.sup_terreno'=>'superficie terreno',
            'especial.*.sup_edificada'=>'superficie edificada',
            'plano_ant.*'=>'número de plano antecedente'
        ];
    }
    
 

}
