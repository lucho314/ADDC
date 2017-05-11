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
        'bis',
        'checksum',
        'imagen',
        'objeto_id',
       'observaciones',
        'estado_id',
        'nombre',
        'nro_dpto',
        'nro_plano',
        'nro_plano_hasta',
        'fecha_registro_visible',
        'nro_matricula',
        'certificado',
        'fecha_certificado'
    ];
    
    protected $binaries = ['imagen'];

    public function getDates() {
        return array('created_at', 'updated_at', 'fecha_registro','fecha_certificado');
    }

    public function setImagenAttribute($value) {
        $img = base64_encode(file_get_contents(($value != '') ? $value->getPathname() : '../public/falta.pdf'));
        $this->attributes['checksum'] = md5($img);
        $this->attributes['imagen'] = $img;
        $this->attributes['nombre'] = ($value != '') ? $value->getClientOriginalName():'falta';
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

    public function cambios() {
        return $this->hasMany(LogCambio::class);
    }

    public function Estado() {
        return $this->belongsTo(Estado::class);
    }

    public function Tipo() {
        return $this->belongsTo(TipoDoc::class, 'tipo_doc_id');
    }

    public function DocumentoSat() {
        return $this->hasMany(DocumentoSat::class, 'documento_id')->orderBy('nro_plano');
    }

    public function ultimoCambio() {
        return $this->belongsTo(DocumentoEstado::class, 'id', 'documento_id')->orderBy('id', 'asc');
    }

    public function incidencias() {
        return $this->hasMany(DocumentoEstado::class, 'documento_id', 'id')->orderBy('id', 'asc');
    }
    
    public function getNroDptoAttribute($value){
        return str_pad($value, 2, "0", STR_PAD_LEFT); 
    }
    
    public function hasVigente(){
        return (bool) $this->DocumentoSat->pluck('vigente')->intersect(['1'])->count();
    }
    
    public function primerImponible(){
        $imponible=$this->DocumentoSat->where('imponible_id','<>',null)->first();
       if(empty($imponible)){
           return $this->DocumentoSat->where('mensura_especial_id','<>',null)->first();
       }
       return $imponible;
    }



    public static function getListaPendientes($mios = false) {
        $doc = Documento::with(['tipo', 'ultimoCambio'])
                ->select('tipo_doc_id', 'nombre', 'usuario_ultima_mod', 'created_at', 'documentos.id')
                ->where('estado_id', '<>', '1')
                ->where('estado_id', '<>', '6');


        if (auth()->user()->isValidador()) {
            $doc->where('estado_id', '=', 2);
        } else if (auth()->user()->isCorrector()) {
            $doc->where('documentos.estado_id', '=', 3)
                    ->whereHas('ultimoCambio', function($query) {
                        $query->where('area_id', auth()->user()->area_id);
                    });
        }


        return $doc;
    }

    public static function getDocumentForValidation($id) {
        $query = Documento::with(['documentoSat', 'antecedentes', 'cambios', 'ultimoCambio', 'incidencias']);
        $doc = $query->findOrFail($id);
        if ($doc->documentoSat[0]->vigente && !is_null($doc->documentoSat[0]->imponible_id)) {
            $query->with('documentoSat.datosSat');
        }
        elseif (!is_null($doc->documentoSat[0]->mensura_especial_id)) {
        $query->with('documentoSat.datosMensuraEspecial');
        }

        if (auth()->user()->isValidador()) {
            $doc->where('estado', '=', 2);
        } else if (auth()->user()->isCorrector()) {
            $doc->where('estado', '=', 3)
                    ->whereHas('ultimoCambio', function($query) {
                        $query->where('area_id', auth()->user()->area_id);
                    });
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
