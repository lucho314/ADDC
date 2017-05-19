<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Antecedente extends Model {
    
    protected $table='tbl_antecedentes';
    public $fillable = [
        'nro_plano',
        'nro_dpto'
    ];
    public $timestamps = false;

    public static function guardar($datos = null, $doc) {
        if (!empty($datos)) {
            $datos = array_filter($datos);
            foreach ($datos as $plano) {
                $antecedente = Antecedente::firstOrCreate(['nro_plano' => "$plano", 'nro_dpto' => $doc->nro_dpto]);
                $doc->antecedentes()->attach($antecedente->id);
            }
        }
    }

    public static function Editar($doc, $datos = array()) {
        DB::table('tbl_antecedente_documento')->where('documento_id', '=', $doc->id)->delete();
        Antecedente::guardar($datos, $doc);
    }

}
