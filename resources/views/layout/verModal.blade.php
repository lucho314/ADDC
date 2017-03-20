<a href=""  id="verModal" data-target="#modal-ver" data-toggle="modal" style="display: none"></a>

<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-ver">

<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button class="close" type="button" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">x</span>
			</button>
			<h4 class="modal-title">Eliminar Articulo</h4>
		</div>
		<div class="modal-body">
			<img id="imagen-modal"  src="{{URL::action('ImagenController@verImagen',10)}}">
		</div>
		<div class="modal-footer">
			<button class="btn btn-default" type="button" data-dismiss="modal"> Cerrar</button>
			<button class="btn btn-primary" type="submit">Confirmar</button>
		</div>
	</div>
</div>

</div>
