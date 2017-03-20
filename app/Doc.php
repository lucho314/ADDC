<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class Doc extends Eloquent {

    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nro_dpto',
        'tipo_doc',
        'fecha_registro',
        'nro_plano',
        'nro_plano_hasta',
        'sup_mensura',
        'sup_titulo',
        'exeso',
        'nro_matricula',
        'estado',
        'bis',
        'checksum',
        'imagen',
        'usuario_actual',
        'responsable',
        'objeto_id',
        //  'linderos',
        'latitud',
        'longitud'
    ];
    protected $binaries = ['imagen'];

    public function temporal() {
        return $this->hasMany(TemporalCatastroSat::class);
    }

    public function Estado() {
        return $this->hasOne(Estado::class, 'id', 'estado');
    }

    public function setResponsableAttribute($value) {

        $this->attributes['responsable'] = strtoupper($value);
    }

//
//    public function setLinderosAttribute($value) {
//        $lindero = "";
//        foreach ($value as $lind) {
//            $lindero .= $lind[0] . '|' . $lind[1] . "|" .strtoupper($lind[2]). "\\";
//        }
//        $this->attributes['linderos'] = substr($lindero, 0, -1);
//    }
//
//    public function getLinderosAttribute($value) {
//        $linderoArray= explode('\\', $value);
//        $lindero=array();
//        $i=0;
//       foreach ($linderoArray as $lin){
//            $datos= explode('|', $lin);
//            $lindero[$i][0]=$datos[0];
//            $lindero[$i][1]=$datos[1];
//            $lindero[$i][2]=$datos[2];
//            $i++;
//        }
//        return $lindero;
//    }



    public function antecedentes() {
        return $this->belongsToMany(Antecedente::class, 'doc_antecedente');
    }

    public function setImagenAttribute($value) {
        $img = base64_encode(file_get_contents(($value != '') ? $value->getPathname() : '../public/falta.pdf'));
        $this->attributes['checksum'] = md5($img);
        $this->attributes['imagen'] = $img;
    }

    public function setNroMatriculaAttribute($value) {
        $matricula = intval($value);
        $this->attributes['nro_matricula'] = "$matricula";
    }

    public static function boot() {
        parent::boot();
        // create a event to happen on updating
        static::updating(function($table) {
            $table->usuario_ultima_mod = auth()->user()->nom_usuario;
        });

// create a event to happen on saving
        static::saving(function($table) {
            $table->usuario_ultima_mod = auth()->user()->nom_usuario;
        });
        static::creating(function($table) {
            $table->usuario_alta = auth()->user()->nom_usuario;
            $table->usuario_ultima_mod = auth()->user()->nom_usuario;
        });
    }

    public function getDates() {
        return array('created_at', 'updated_at', 'fecha_registro');
    }

    public static function getListaPendientes($mios = false) {
        $doc = Doc::select('id', 'nro_dpto', 'nro_plano', 'nro_plano_hasta', 'created_at', 'usuario_ultima_mod', 'tipo_doc');

        if (auth()->user()->isValidador() || auth()->user()->isAdmin()) {

            $doc->where('estado', '=', '2');
        } else if (auth()->user()->hasRoles(['carga'])) {
            $doc->where('estado', '<>', '1');
            $doc->where('usuario_alta', '=', auth()->user()->nom_usuario);
        } else {
            $doc->where('estado', '=', '3');
            if ($mios) {
                $doc->where('usuario_actual', '=', auth()->user()->getAuthIdentifier());
            } else {
                $doc->whereNull('usuario_actual');
            }
        }
      //  dd($doc->getQuery());
        return $doc;
    }

}
