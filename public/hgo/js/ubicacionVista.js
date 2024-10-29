
$(document).ready(function(){
	
	const modalHtmlUbicacion = `<div class='modal fade' id='modalAddUbicacion' tabindex='-1'>
		<div class='modal-dialog modal-md'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>Detalle Ubicacion</h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>×</span>
				</button>
			</div>
			<div class='modal-body'>
				<div class='form-group row'>
					<div class='col-12 form-group row' hidden>
						<label for = 'idubicacionadd' class='col-sm-4'>Idubicacion:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='idubicacionadd' name='idubicacionadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
					<div class='col-12 form-group row'>
						<label for = 'nombretipoubicacionadd' class='col-sm-4' for='id'>Nombretipoubicacion:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='nombretipoubicacionadd' name='nombretipoubicacionadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-success btn-sm' id='btnAddModalAgregarUbicacion'>Agregar</button>
				<button type='button' class='btn btn-primary btn-sm' id='btnAddModalCerrarUbicacion' data-dismiss='modal'>Cerrar</button>
			</div>
			</div>
		</div>
	</div>`;
	$('body').append(modalHtmlUbicacion);
	
	var NuevoUbicacion;
	
	$('#btnAddUbicacion').click(function(){
		debugger
		LimpiarModalDatosUbicacionAdd();
		$('#btnModalAddUbicacion').toggle(true);
		$('#modalAddUbicacion').modal();
	});
	
	$('#btnAddModalAgregarUbicacion').click(function(){
		if(ValidarCamposVaciosUbicacionAdd() != 0)
		{
			alert('Completar campos obligatorios');
		}
		else
		{
			RecolectarDatosUbicacionAdd();
			EnviarInformacionUbicacionAdd('agregar', NuevoUbicacion, true);
		}
	});
	
	function EnviarInformacionUbicacionAdd(accion, objEvento, modal, pag=1){
		$.ajax({
			type: 'POST',
			url: base_url+'/ubicacion/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				debugger
				var resp = JSON.parse(msg);
				if (modal) {
					$('#modalAddUbicacion').modal('toggle');
					LimpiarModalDatosUbicacionAdd();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								actualizarSelectUbicacionAdd();
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
	function actualizarSelectUbicacionAdd() {
		$('#idubicacion').find('option').remove();
		$.get(`${base_url}/ubicacion/listaSelect2`, function(response) {
			$('#idubicacion').append(`<option value='0'>-- SELECCIONAR1 --</option>`);
			data = JSON.parse(response);
			let ultimoItem = data[0].idubicacion;
			$.each(data, function(index, item) {
				$('#idubicacion').append($('<option>', {
				value: item.idubicacion,
				text: item.nombretipoubicacion
				}));
			});
			$('#idubicacion').select2();
			if (ultimoItem) {
				$('#idubicacion').val(ultimoItem).trigger('change');
			}
		})
		.fail(function() {
			console.error('Error al obtener los datos');
		});
	};
	
	function RecolectarDatosUbicacionAdd(){
		NuevoUbicacion = {
			nombretipoubicacion: $('#nombretipoubicacionadd').val().toUpperCase(),
			estado: 1,
		};
	}
	
	function LimpiarModalDatosUbicacionAdd(){
		$('#nombretipoubicacionadd').val('');
	}
	
	function ValidarCamposVaciosUbicacionAdd(){
		var error = 0;
		if ($('#nombretipoubicacionadd').val() == ''){
			Resaltado('nombretipoubicacionadd');
			error++;
		}else{
			NoResaltado('nombretipoubicacionadd');
		}
		return error;
	}
});
