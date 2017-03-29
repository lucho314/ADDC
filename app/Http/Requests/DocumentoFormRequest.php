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
      // dd($datos->all());
        return [
            'gral.nro_dpto'=>'required|numeric|in:01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17',
            'gral.nro_plano'=>'required|numeric|min:1',
            'gral.nro_plano_hasta'=>'required|numeric|min:'.$datos->gral['nro_plano'].'|doc_unico:'.$datos->gral['nro_dpto'].','.$datos->gral['nro_plano'].','.$datos->gral['nro_plano_hasta'].','.(isset($datos->gral['id'])?$datos->gral['id']:0).','.$datos->gral['tipo_doc'],
            'gral.tipo_doc'=>'required',
            'gral.fecha_registro'=>'date',
            'gral.inscripcion'=>'required|regex:/^[0-9]+\*?/',
            'gral.nro_matricula'=>'required|regex:/^[0-9]+\*?/',
            'gral.responsable'=>'required',
            'gral.tipo_planta'=>'required|regex:/^[0-9]+\*?/',
            'gral.sup_mensura'=>'required|numeric',
            'gral.sup_titulo'=>'required|numeric',
            'gral.exeso'=>'required|numeric',
            'gral.departamento'=>'required|regex:/^[0-9]+\*?/',
            'gral.localidad'=>'required|regex:/^[0-9]+\*?/',
            'gral.distrito'=>'required|regex:/^[0-9]+\*?/',
            'gral.seccion'=>'regex:/^[0-9]+\*?/',
            'lote.*.nro_plano'=>'required|regex:/^[0-9]+\*?/',
            'lote.*.nro_partida'=>'required|regex:/^[0-9]+\*?/',
            'lote.*.sup_terreno'=>'required|regex:/^[0-9]+\*?/',
            'lote.*.sup_edificada'=>'required|regex:/^[0-9]+\*?/',
            'plano_ant.*'=>'numeric'
//            'lote.*.grupo'=>'',
//            'lote.*.manzana'=>'required|numeric',
//            'lote.*.parcela'=>'required|numeric',
//            'lote.*.subparcela'=>'required|numeric',
//            'lote.*.chacra'=>'required|numeric',
//            'lote.*.quinta'=>'required|numeric',
//            'lote.*.lamina'=>'required|numeric',
//            'lote.*.sublamina'=>'required|numeric',
        ];
    }
    
public function attributes(){
        return [
            
            'gral.nro_dpto'=>'departamento',
            'gral.nro_plano'=>'número de plano',
            'gral.nro_plano_hasta'=>'número de plano hasta',
            'gral.tipo_doc'=>'tipo de documento',
            'gral.fecha_registro'=>'fecha de registro',
            'gral.inscripcion'=>'fecha de inscripción',
            'gral.nro_matricula'=>'número de matrícula',
            'gral.responsable'=>'responsable',
            'gral.tipo_planta'=>'tipo de planta',
            'gral.sup_mensura'=>'superficie según mensura',
            'gral.sup_titulo'=>'superficie según título',
            'gral.exeso'=>'exceso',
            'gral.departamento'=>'departamento',
            'gral.localidad'=>'localidad',
            'gral.distrito'=>'distrito',
            'gral.seccion'=>'sección',
            'lote.*.nro_plano'=>'número de plano',
            'lote.*.nro_partida'=>'número de partida',
            'lote.*.sup_terreno'=>'superficie terreno',
            'lote.*.sup_edificada'=>'superficie edificada',
            'plano_ant.*'=>'número de plano antecedente'
            
        ];
    }
    
 

}
