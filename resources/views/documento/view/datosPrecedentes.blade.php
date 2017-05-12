<div class="container"> 
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tipo documento</th>
                        <th>Número de plano</th>
                        <th>Número de partida</th>
                        <th>Fecha de registro</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($precedentes as $pre)
                    <tr>
                        <td>{{$pre->tipo->descripcion}}</td>
                        <td>{{$pre->documentoSat[0]->nro_plano}}</td>
                        <td>{{$pre->documentoSat[0]->nro_partida}}</td>
                        <td>{{($pre->fecha_registro)?$pre->fecha_registro->format('d/m/Y') : ''}}</td>
                        <td><a href="/documento/view/{{$pre->id}}" target="_blank" class="btn btn-info btn-xs">Ver imagen</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>