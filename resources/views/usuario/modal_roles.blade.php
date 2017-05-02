<div class="modal fade" id="modal_roles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="modificar_roles">
                {{ csrf_field() }} 
                <input type="hidden" id="id">
                <input name="_method" type="hidden" value="PATCH">
                <div class="modal-header" id="header_modal">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Roles usuario: </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>ÁREAS</label>
                        <select name="area_id" id="area_id" class="form-control" required>
                            <option value="">Seleccione area</option>
                            @foreach($areas as $area)
                            <option value="{{$area->id}}">{{$area->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
                     <label>ROLES</label>
                    <div class="row">
                        
                        <div class="col-md-12">
                           
                            @foreach($roles as $id=>$nombre)

                            <div class="col-md-6">
                                <div class="form-group">           
                                    <label>
                                        <input type="checkbox" checked="false" name="roles[]" value="{{$id}}" id="{{$id}}">
                                        {{$nombre}}
                                    </label>
                                </div>
                            </div>

                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success btn-ok">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>