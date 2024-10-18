
$(document).ready(function(){
	
	const modalHtmlNeumatico = `<div class='modal fade' id='modalAddNeumatico' tabindex='-1'>
		<div class='modal-dialog modal-lg'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>Detalle Neumatico</h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>×</span>
				</button>
			</div>
			<div class='modal-body'>
				<div class='form-group row'>
					<div class='col-6 form-group row' hidden>
						<label for = 'idneumaticoadd' class='col-sm-4'>Idneumatico:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='idneumaticoadd' name='idneumaticoadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
					<div class='col-6 form-group row'>
						<label for = 'nombreneumaticoadd' class='col-sm-4' for='id'>Nombreneumatico:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='nombreneumaticoadd' name='nombreneumaticoadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-success btn-sm' id='btnAddModalAgregarNeumatico'>Agregar</button>
				<button type='button' class='btn btn-primary btn-sm' id='btnAddModalCerrarNeumatico' data-dismiss='modal'>Cerrar</button>
			</div>
			</div>
		</div>
	</div>`;
	$('body').append(modalHtmlNeumatico);
	
	var NuevoNeumatico;
	
	$('#btnAddNeumatico').click(function(){
		LimpiarModalDatosNeumaticoAdd();
		$('#btnModalAddNeumatico').toggle(true);
		$('#modalAddNeumatico').modal();
	});
	
	$('#btnAddModalAgregarNeumatico').click(function(){
		if(ValidarCamposVaciosNeumaticoAdd() != 0)
		{
			alert('Completar campos obligatorios');
		}
		else
		{
			RecolectarDatosNeumaticoAdd();
			EnviarInformacionNeumaticoAdd('agregar', NuevoNeumatico, true);
		}
	});
	
	function EnviarInformacionNeumaticoAdd(accion, objEvento, modal, pag=1){
		$.ajax({
			type: 'POST',
			url: base_url+'/neumatico/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
		debugger
				var resp = JSON.parse(msg);
				if (modal) {
					$('#modalAgregarNeumatico').modal('toggle');
					LimpiarModalDatosNeumaticoAdd();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								actualizarSelectNeumaticoAdd();
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
	function actualizarSelectNeumaticoAdd() {
		var nuevaOpcion = $('<option>', {
			value: NuevoNeumatico.idneumatico,
			text: NuevoNeumatico.nombreneumatico,
		});
		$('#nidneumatico').append(nuevaOpcion);
		$('#nidneumatico').val(NuevoNeumatico.nidneumatico);
	};
	
	function RecolectarDatosNeumaticoAdd(){
		NuevoNeumatico = {
			idneumatico: $('#idneumaticoadd').val().toUpperCase(),
			nombreneumatico: $('#nombreneumaticoadd').val().toUpperCase(),
			estado: 1,
		};
	}
	
	function LimpiarModalDatosNeumaticoAdd(){
		$('#idneumaticoadd').val('');
		$('#nombreneumaticoadd').val('');
	}
	
	function ValidarCamposVaciosNeumaticoAdd(){
		var error = 0;
		if ($('#idneumaticoadd').val() == ''){
			Resaltado('idneumaticoadd');
			error++;
		}else{
			NoResaltado('idneumaticoadd');
		}
		if ($('#nombreneumaticoadd').val() == ''){
			Resaltado('nombreneumaticoadd');
			error++;
		}else{
			NoResaltado('nombreneumaticoadd');
		}
		return error;
	}
});
