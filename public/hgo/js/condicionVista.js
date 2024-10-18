
$(document).ready(function(){
	
	const modalHtmlCondicion = `<div class='modal fade' id='modalAddCondicion' tabindex='-1'>
		<div class='modal-dialog modal-md'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>Detalle Condicion</h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>×</span>
				</button>
			</div>
			<div class='modal-body'>
				<div class='form-group row'>
					<div class='col-12 form-group row'>
						<label for = 'idcondicionadd' class='col-sm-4'>Idcondicion:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='idcondicionadd' name='idcondicionadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
					<div class='col-12 form-group row'>
						<label for = 'nombrecondicionadd' class='col-sm-4' for='id'>Nombrecondicion:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='nombrecondicionadd' name='nombrecondicionadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-success btn-sm' id='btnAddModalAgregarCondicion'>Agregar</button>
				<button type='button' class='btn btn-primary btn-sm' id='btnAddModalCerrarCondicion' data-dismiss='modal'>Cerrar</button>
			</div>
			</div>
		</div>
	</div>`;
	$('body').append(modalHtmlCondicion);
	
	var NuevoCondicion;
	
	$('#btnAddCondicion').click(function(){
		debugger
		LimpiarModalDatosCondicionAdd();
		$('#btnModalAddCondicion').toggle(true);
		$('#modalAddCondicion').modal();
	});
	
	$('#btnAddModalAgregarCondicion').click(function(){
		if(ValidarCamposVaciosCondicionAdd() != 0)
		{
			alert('Completar campos obligatorios');
		}
		else
		{
			RecolectarDatosCondicionAdd();
			EnviarInformacionCondicionAdd('agregar', NuevoCondicion, true);
		}
	});
	
	function EnviarInformacionCondicionAdd(accion, objEvento, modal, pag=1){
		$.ajax({
			type: 'POST',
			url: base_url+'/condicion/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				debugger
				var resp = JSON.parse(msg);
				if (modal) {
					$('#modalAddCondicion').modal('toggle');
					LimpiarModalDatosCondicionAdd();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								actualizarSelectCondicionAdd();
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}
			},
			error: function(){
				Swal.fire(
					'Oops...',
					'Something went wrong!',
					'error'
				)
			}
		});
	}
	// Función para actualizar el select
	function actualizarSelectCondicionAdd() {
		var nuevaOpcion = $('<option>', {
			text: NuevoCondicion.nombrecondicion,
		});
		$('#idcondicion').append(nuevaOpcion);
		$('#idcondicion').val(NuevoCondicion.idcondicion);
	};
	
	function RecolectarDatosCondicionAdd(){
		NuevoCondicion = {
			nombrecondicion: $('#nombrecondicionadd').val().toUpperCase(),
			estado: 1,
		};
	}
	
	function LimpiarModalDatosCondicionAdd(){
		$('#nombrecondicionadd').val('');
	}
	
	function ValidarCamposVaciosCondicionAdd(){
		var error = 0;
		if ($('#nombrecondicionadd').val() == ''){
			Resaltado('nombrecondicionadd');
			error++;
		}else{
			NoResaltado('nombrecondicionadd');
		}
		return error;
	}
});
