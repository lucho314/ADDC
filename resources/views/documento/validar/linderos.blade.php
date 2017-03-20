<div class="container" >
    <div class="panel panel-default">
        <div class="panel-body">


            <div  id="datosGenerales">
                <?php $i=0; ?>
                @foreach($documento->linderos as $lind)
                <div class="form-inline" style="margin-top: 1%">
                    <input type="text" size="1" name="linderos[{{$i}}][]" value="{{$lind[0]}}"> -
                    <input type="text" size="1" name="linderos[{{$i}}][]" value="{{$lind[1]}}">
                    <textarea class="form-control linderos" name="linderos[{{$i}}][]" id="linderos" rows="2">{{$lind[2]}}</textarea>
                   
                </div>
                <?php $i++; ?>
                @endforeach
            </div>
        </div>
    </div>
</div>
