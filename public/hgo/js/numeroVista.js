
$(document).ready(function(){
	
	const modalHtmlNumero = `<div class='modal fade' id='modalAddNumero' tabindex='-1'>
		<div class='modal-dialog modal-md'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>Detalle Numero</h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>×</span>
				</button>
			</div>
			<div class='modal-body'>
				<div class='form-group row'>
					<div class='col-12 form-group row' hidden>
						<label for = 'idnumeroadd' class='col-sm-4'>Idnumero:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='idnumeroadd' name='idnumeroadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
					<div class='col-12 form-group row'>
						<label for = 'nombrenumeroadd' class='col-sm-4' for='id'>Nombrenumero:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='nombrenumeroadd' name='nombrenumeroadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-success btn-sm' id='btnAddModalAgregarNumero'>Agregar</button>
				<button type='button' class='btn btn-primary btn-sm' id='btnAddModalCerrarNumero' data-dismiss='modal'>Cerrar</button>
			</div>
			</div>
		</div>
	</div>`;
	$('body').append(modalHtmlNumero);
	
	var NuevoNumero;
	
	$('#btnAddNumero').click(function(){
		debugger
		LimpiarModalDatosNumeroAdd();
		$('#btnModalAddNumero').toggle(true);
		$('#modalAddNumero').modal();
	});
	
	$('#btnAddModalAgregarNumero').click(function(){
		if(ValidarCamposVaciosNumeroAdd() != 0)
		{
			alert('Completar campos obligatorios');
		}
		else
		{
			RecolectarDatosNumeroAdd();
			EnviarInformacionNumeroAdd('agregar', NuevoNumero, true);
		}
	});
	
	function EnviarInformacionNumeroAdd(accion, objEvento, modal, pag=1){
		$.ajax({
			type: 'POST',
			url: base_url+'/numero/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				debugger
				var resp = JSON.parse(msg);
				if (modal) {
					$('#modalAddNumero').modal('toggle');
					LimpiarModalDatosNumeroAdd();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								actualizarSelectNumeroAdd();
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
	function actualizarSelectNumeroAdd() {
		var nuevaOpcion = $('<option>', {
			text: NuevoNumero.nombrenumero,
		});
		$('#idnumero').append(nuevaOpcion);
		$('#idnumero').val(NuevoNumero.idnumero);
	};
	
	function RecolectarDatosNumeroAdd(){
		NuevoNumero = {
			nombrenumero: $('#nombrenumeroadd').val().toUpperCase(),
			estado: 1,
		};
	}
	
	function LimpiarModalDatosNumeroAdd(){
		$('#nombrenumeroadd').val('');
	}
	
	function ValidarCamposVaciosNumeroAdd(){
		var error = 0;
		if ($('#nombrenumeroadd').val() == ''){
			Resaltado('nombrenumeroadd');
			error++;
		}else{
			NoResaltado('nombrenumeroadd');
		}
		return error;
	}
});
