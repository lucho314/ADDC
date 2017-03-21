<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Doc;
use DB;

class Antecedente extends Model {

    public $fillable = [
        'nro_plano',
        'nro_dpto'
    ];
  public $timestamps = false;
    
    public static  function guardar(array $datos,Doc $doc) {
        $datos=array_filter($datos); 
        foreach ($datos as $plano) {
            $antecedente= Antecedente::firstOrCreate(['nro_plano'=>"$plano",'nro_dpto'=>$doc->nro_dpto]);
            $doc->antecedentes()->attach($antecedente->id);
        }
    }
    
    public static function Editar(Doc $doc, $datos = array()){
        DB::table('doc_antecedente')->where('doc_id','=',$doc->id)->delete();
        Antecedente::guardar($datos, $doc);
    }

}
