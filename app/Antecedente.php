<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Doc;

class Antecedente extends Model {

    public $fillable = [
        'nro_plano'
    ];
  public $timestamps = false;
    
    public static  function guardar(array $datos,Doc $doc) {
        $datos=array_filter($datos); 
        foreach ($datos as $plano) {
            $antecedente = Antecedente::where('nro_plano', '=', $plano)
                    ->where('nro_dpto','=',$doc->nro_dpto)
                    ->first();
            if($antecedente){
                $doc->antecedentes()->attach($antecedente->id);
            }
            else {
                $antecedente=new Antecedente();
                $antecedente->nro_plano="$plano";
                $antecedente->nro_dpto=$doc->nro_dpto;
                $antecedente->save();
                $doc->antecedentes()->attach($antecedente->id);
            }
        }
    }

}
