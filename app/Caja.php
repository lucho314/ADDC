<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Caja extends Model {
     protected $table='tbl_cajas';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'dpto',
        'sector',
        'modulo',
        'estante',
        'posicion',
        'profundidad',
        'numero_caja',
        'completo',
    ];

    public function contenidos() {
        return $this->hasMany(Contenido::class);
    }

    public static function boot() {
        parent::boot();

// create a event to happen on saving
        static::saving(function($table) {
            $table->usuario_alta = auth()->user()->nom_usuario;
            $table->completo = '0';
            $table->tipo_doc = '2';
        });
    }


    public static function buscarMayorNumeroCaja($estantes) {
        $aux = 0;
        $aux = ($estantes[0]->numero_caja > $estantes[1]->numero_caja) ? $estantes[0] : $estantes[1];
        return $aux;
    }

    public function buscarUltimoRango() {
        $mayor = 0;
        foreach ($this->contenidos as $contenido) {
            if ($contenido->numero_hasta > $mayor) {
                $mayor = $contenido->numero_hasta;
            }
        }
        unset($this->contenidos);
        $this->contenidos = $mayor;
        return $this;
    }

    public static function formatearEtiqueta(&$pdf, $datos, $tplIdx,$i) {
        $nombreDpto=DB::table('vw_localidades')->where('codigo_de','=',$datos->dpto)->first();
        $x = ($i==0 || $i==2)? 0:45;
        $y = ($i==0 || $i==1)? 0:60;

        $pdf->SetFont('times', 'BI', 12);
        $pdf->useTemplate($tplIdx, 3 + $x, 5 + $y, 45, 55, false);
        $pdf->SetXY(10 + $x, 24 + $y);
        $pdf->Write(0, $datos->numero_caja);

        $pdf->SetXY(28 + $x, 24 + $y);
        $pdf->Write(0, 'Tela');

        $pdf->SetXY(10 + $x, 32 + $y);
        $pdf->Write(0, $nombreDpto->departamento);

        $pdf->SetFont('times', 'BI', 10);
        $pdf->SetXY(7 + $x, 42 + $y);
        $pdf->Write(0, $datos->contenidos[0]->numero_desde);

        $pdf->SetXY(28 + $x, 42 + $y);
        $pdf->Write(0, $datos->contenidos[0]->numero_hasta);

        $pdf->SetFont('times', 'BI', 12);

        $pdf->SetXY(7 + $x, 55 + $y);
        $pdf->Write(0, $datos->sector);

        $pdf->SetXY(15 + $x, 55 + $y);
        $pdf->Write(0, $datos->modulo);

        $pdf->SetXY(23 + $x, 55 + $y);
        $pdf->Write(0, $datos->estante);

        $pdf->SetXY(30 + $x, 55 + $y);
        $pdf->Write(0, $datos->posicion);

        $pdf->SetXY(40 + $x, 55 + $y);
        $pdf->Write(0, $datos->profundidad);
    }

}
