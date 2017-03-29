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
            if ($parameters[4] === 'Ficha de transferencia') {
                return true;
            } $row = DB::table('docs')->where('nro_dpto', '=', $parameters[0])
                    ->where('nro_plano', '<=', $parameters[2])
                    ->where('nro_plano_hasta', '>=', $parameters[1]);
            if (isset($parameters[3])) {
                $row->where('id', '<>', $parameters[3]);
            }
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
