
$(document).ready(function(){
	
	const modalHtmlBanda = `<div class='modal fade' id='modalAddBanda' tabindex='-1'>
		<div class='modal-dialog modal-lg'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>Detalle Banda</h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>×</span>
				</button>
			</div>
			<div class='modal-body'>
				<div class='form-group row'>
					<div class='col-6 form-group row' hidden>
						<label for = 'idbandaadd' class='col-sm-4'>Idbanda:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='idbandaadd' name='idbandaadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
					<div class='col-6 form-group row'>
						<label for = 'nombrebandaadd' class='col-sm-4' for='id'>Nombrebanda:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='nombrebandaadd' name='nombrebandaadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-success btn-sm' id='btnAddModalAgregarBanda'>Agregar</button>
				<button type='button' class='btn btn-primary btn-sm' id='btnAddModalCerrarBanda' data-dismiss='modal'>Cerrar</button>
			</div>
			</div>
		</div>
	</div>`;
	$('body').append(modalHtmlBanda);
	
	var NuevoBanda;
	
	$('#btnAddBanda').click(function(){
		LimpiarModalDatosBandaAdd();
		$('#btnModalAddBanda').toggle(true);
		$('#modalAddBanda').modal();
	});
	
	$('#btnAddModalAgregarBanda').click(function(){
		if(ValidarCamposVaciosBandaAdd() != 0)
		{
			alert('Completar campos obligatorios');
		}
		else
		{
			RecolectarDatosBandaAdd();
			EnviarInformacionBandaAdd('agregar', NuevoBanda, true);
		}
	});
	
	function EnviarInformacionBandaAdd(accion, objEvento, modal, pag=1){
		$.ajax({
			type: 'POST',
			url: base_url+'/banda/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
		debugger
				var resp = JSON.parse(msg);
				if (modal) {
					$('#modalAgregarBanda').modal('toggle');
					LimpiarModalDatosBandaAdd();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								actualizarSelectBandaAdd();
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
	function actualizarSelectBandaAdd() {
		var nuevaOpcion = $('<option>', {
			value: NuevoBanda.idbanda,
			text: NuevoBanda.nombrebanda,
		});
		$('#nidbanda').append(nuevaOpcion);
		$('#nidbanda').val(NuevoBanda.nidbanda);
	};
	
	function RecolectarDatosBandaAdd(){
		NuevoBanda = {
			nidbanda: $('#idbandaadd').val().toUpperCase(),
			nombrecliente: $('#nombrebandaadd').val().toUpperCase(),
			estado: 1,
		};
	}
	
	function LimpiarModalDatosBandaAdd(){
		$('#idbandaadd').val('');
		$('#nombrebandaadd').val('');
	}
	
	function ValidarCamposVaciosBandaAdd(){
		var error = 0;
		if ($('#idbandaadd').val() == ''){
			Resaltado('idbandaadd');
			error++;
		}else{
			NoResaltado('idbandaadd');
		}
		if ($('#nombrebandaadd').val() == ''){
			Resaltado('nombrebandaadd');
			error++;
		}else{
			NoResaltado('nombrebandaadd');
		}
		return error;
	}
});
