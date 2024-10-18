
$(document).ready(function(){
	
	const modalHtmlServicio = `<div class='modal fade' id='modalAddServicio' tabindex='-1'>
		<div class='modal-dialog modal-xl'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>Detalle Servicio</h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>×</span>
				</button>
			</div>
			<div class='modal-body'>
				<div class='form-group row'>
					<div class='col-6 form-group row' hidden>
						<label for = 'idservicioadd' class='col-sm-4'>Idservicio:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='idservicioadd' name='idservicioadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-success btn-sm' id='btnAddModalAgregarServicio'>Agregar</button>
				<button type='button' class='btn btn-primary btn-sm' id='btnAddModalCerrarServicio' data-dismiss='modal'>Cerrar</button>
			</div>
			</div>
		</div>
	</div>`;
	$('body').append(modalHtmlServicio);
	
	var NuevoServicio;
	
	$('#btnAddServicio').click(function(){
		LimpiarModalDatosServicioAdd();
		$('#btnModalAddServicio').toggle(true);
		$('#modalAddServicio').modal();
	});
	
	$('#btnAddModalAgregarServicio').click(function(){
		if(ValidarCamposVaciosServicioAdd() != 0)
		{
			alert('Completar campos obligatorios');
		}
		else
		{
			RecolectarDatosServicioAdd();
			EnviarInformacionServicioAdd('agregar', NuevoServicio, true);
		}
	});
	
	function EnviarInformacionServicioAdd(accion, objEvento, modal, pag=1){
		$.ajax({
			type: 'POST',
			url: base_url+'/servicio/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
		debugger
				var resp = JSON.parse(msg);
				if (modal) {
					$('#modalAgregarServicio').modal('toggle');
					LimpiarModalDatosServicioAdd();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								actualizarSelectServicioAdd();
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
	function actualizarSelectServicioAdd() {
		var nuevaOpcion = $('<option>', {
			value: NuevoServicio.idservicio,
		});
		$('#nidservicio').append(nuevaOpcion);
		$('#nidservicio').val(NuevoServicio.nidservicio);
	};
	
	function RecolectarDatosServicioAdd(){
		NuevoServicio = {
			idservicio: $('#idservicioadd').val().toUpperCase(),
			estado: 1,
		};
	}
	
	function LimpiarModalDatosServicioAdd(){
		$('#idservicioadd').val('');
	}
	
	function ValidarCamposVaciosServicioAdd(){
		var error = 0;
		if ($('#idservicioadd').val() == ''){
			Resaltado('idservicioadd');
			error++;
		}else{
			NoResaltado('idservicioadd');
		}
		return error;
	}
});
