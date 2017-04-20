<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class Documento extends Eloquent {

    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'tipo_doc_id',
        'fecha_registro',
        //'bis',
        'checksum',
        'imagen',
        'objeto_id',
        //'fecha_registro_visible'
        //  'linderos',
        'estado_id',
        'nombre',
        'nro_dpto',
        'nro_plano',
        'nro_plano_hasta',
        'fecha_registro_visible'
    ];
    protected $binaries = ['imagen'];

    
  
    public function setImagenAttribute($value) {
    
        $img = base64_encode(file_get_contents(($value != '') ? $value->getPathname() : '../public/falta.pdf'));
        $this->attributes['checksum'] = md5($img);
        $this->attributes['imagen'] = $img;
         $this->attributes['nombre']=$value->getClientOriginalName();
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

    
    

  public function Antecedentes() {
        return $this->belongsToMany(Antecedente::class);
    }

    public function Estado() {
        return $this->hasOne(Estado::class);
    }

    public function DocumentoSat() {
        return $this->hasMany(DocumentoSat::class);
    }

    public function Tipo() {
        return $this->hasOne(TipoDoc::class,'id','tipo_doc_id');
    }
    
    
    
     public static function getListaPendientes($mios = false) {
        $doc = Documento::with('tipo')->select('tipo_docs.descripcion','tipo_doc_id','nombre','usuario_ultima_mod','created_at','documentos.id');

        if (auth()->user()->isValidador() || auth()->user()->isAdmin()) {

            $doc->where('estado_id', '=', '2');
        } else if (auth()->user()->hasRoles(['carga'])) {
            $doc->where('estado_id', '<>', '1');
            $doc->where('usuario_alta', '=', auth()->user()->nom_usuario);
        } else {
            $doc->where('estado_id', '=', '3');
            if ($mios) {
                $doc->where('usuario_actual', '=', auth()->user()->getAuthIdentifier());
            } else {
                $doc->whereNull('usuario_actual');
            }
        }
      
        return $doc;
    }
    
    
    
     public static function getDocumentForValidation($id) {
        $query = Documento::with(['documentoSat', 'antecedentes']);
        $doc=$query->findOrFail($id);
        if( $doc->documentoSat[0]->vigente)
        {
            $query->with('documentoSat.datosSat');
        }
//        if (auth()->user()->isAdmin()) {
//            $doc->Where(function ($query) {
//                $query->where('estado', '<>', 3)
//                        ->orWhere(function ($sql) {
//                            $sql->where('estado', '=', 3)
//                            ->whereNull('usuario_actual')
//                            ->orWhere('usuario_actual', '=', auth()->user()->getAuthIdentifier());
//                        });
//            });
//        } else if (auth()->user()->isValidador()) {
//            $doc->where('estado', '=', 2);
//        } else if (auth()->user()->isCorrector()) {
//            $doc->where('estado', '=', 3)
//                    ->where(function ($query) {
//                        $query->whereNull('usuario_actual')
//                        ->orWhere('usuario_actual', '=', auth()->user()->getAuthIdentifier());
//                    });
//        }
        
        
        return $query;
    }


}
