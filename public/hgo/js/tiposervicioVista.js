
$(document).ready(function(){
	
	const modalHtmlTiposervicio = `<div class='modal fade' id='modalAddTiposervicio' tabindex='-1'>
		<div class='modal-dialog modal-lg'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>Detalle Tiposervicio</h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>×</span>
				</button>
			</div>
			<div class='modal-body'>
				<div class='form-group row'>
					<div class='col-6 form-group row' hidden>
						<label for = 'idtiposervicioadd' class='col-sm-4'>Idtiposervicio:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='idtiposervicioadd' name='idtiposervicioadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
					<div class='col-6 form-group row'>
						<label for = 'nombretiposervicioadd' class='col-sm-4' for='id'>Nombretiposervicio:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='nombretiposervicioadd' name='nombretiposervicioadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-success btn-sm' id='btnAddModalAgregarTiposervicio'>Agregar</button>
				<button type='button' class='btn btn-primary btn-sm' id='btnAddModalCerrarTiposervicio' data-dismiss='modal'>Cerrar</button>
			</div>
			</div>
		</div>
	</div>`;
	$('body').append(modalHtmlTiposervicio);
	
	var NuevoTiposervicio;
	
	$('#btnAddTiposervicio').click(function(){
		LimpiarModalDatosTiposervicioAdd();
		$('#btnModalAddTiposervicio').toggle(true);
		$('#modalAddTiposervicio').modal();
	});
	
	$('#btnAddModalAgregarTiposervicio').click(function(){
		if(ValidarCamposVaciosTiposervicioAdd() != 0)
		{
			alert('Completar campos obligatorios');
		}
		else
		{
			RecolectarDatosTiposervicioAdd();
			EnviarInformacionTiposervicioAdd('agregar', NuevoTiposervicio, true);
		}
	});
	
	function EnviarInformacionTiposervicioAdd(accion, objEvento, modal, pag=1){
		$.ajax({
			type: 'POST',
			url: base_url+'/tiposervicio/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
		debugger
				var resp = JSON.parse(msg);
				if (modal) {
					$('#modalAgregarTiposervicio').modal('toggle');
					LimpiarModalDatosTiposervicioAdd();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								actualizarSelectTiposervicioAdd();
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
	function actualizarSelectTiposervicioAdd() {
		var nuevaOpcion = $('<option>', {
			value: NuevoTiposervicio.idtiposervicio,
			text: NuevoTiposervicio.nombretiposervicio,
		});
		$('#nidtiposervicio').append(nuevaOpcion);
		$('#nidtiposervicio').val(NuevoTiposervicio.nidtiposervicio);
	};
	
	function RecolectarDatosTiposervicioAdd(){
		NuevoTiposervicio = {
			idtiposervicio: $('#idtiposervicioadd').val().toUpperCase(),
			nombretiposervicio: $('#nombretiposervicioadd').val().toUpperCase(),
			estado: 1,
		};
	}
	
	function LimpiarModalDatosTiposervicioAdd(){
		$('#idtiposervicioadd').val('');
		$('#nombretiposervicioadd').val('');
	}
	
	function ValidarCamposVaciosTiposervicioAdd(){
		var error = 0;
		if ($('#idtiposervicioadd').val() == ''){
			Resaltado('idtiposervicioadd');
			error++;
		}else{
			NoResaltado('idtiposervicioadd');
		}
		if ($('#nombretiposervicioadd').val() == ''){
			Resaltado('nombretiposervicioadd');
			error++;
		}else{
			NoResaltado('nombretiposervicioadd');
		}
		return error;
	}
});
