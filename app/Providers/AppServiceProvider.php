<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use DB;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Validator::extend('doc_unico', function ($attribute, $value, $parameters, $validator) {

            //dd($parameters)
            $row = DB::table('documentos')->where('nro_dpto', '=', $parameters[0])
                    ->where('nro_plano', '<=', $parameters[2])
                    ->where('nro_plano_hasta', '>=', $parameters[1]);
            if (isset($parameters[3])) {
                $row->where('id', '<>', $parameters[3])
                        ->where('tipo_doc_id', '=', $parameters[4]);
            } 
            if ($parameters[4] === '2') {
                if (isset($parameters[5])) {
                    $row->where('fecha_certificado', '=', $parameters[5]);
                    $row->where('tipo_doc_id', '=', $parameters[4]);
                }
            }
            //dd($row->get());
            return $row->count() == 0;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
