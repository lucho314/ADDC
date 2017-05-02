<style>
        fieldset 
	{
		border: 1px solid #ddd !important;
		margin: 0;
		xmin-width: 0;
		padding: 10px;       
		position: relative;
		border-radius:4px;
		background-color:#f5f5f5;
		padding-left:10px!important;
	}	
	
		legend
		{
			font-size:14px;
			font-weight:bold;
			margin-bottom: 0px; 
			width: 35%; 
			border: 1px solid #ddd;
			border-radius: 4px; 
			padding: 5px 5px 5px 10px; 
			background-color: #ffffff;
		}
</style>



<div class="container">

    <div class="panel panel-default" id="datos">

        <div class="panel-heading">
            <a href="#"  data-toggle="collapse" data-target="#datosTitulares"><div style="width:100%;" id="tituloPanel">Responsables</div></a>
        </div>
        <div class="panel-body collapse"  id="datosTitulares" >

            <fieldset class="col-md-6">    	
                <legend>Fieldset Title</legend>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>Fieldset content...</p>
                    </div>
                </div>

            </fieldset>				

            
            <table class="table table-border table-striped table-responsive" id="tabla-responsables">
                <thead>
                    <tr>
                        <th>Cuit</th>
                        <th>Nombre</th>
                        <th>Fecha Ocupacion</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>

</div>
