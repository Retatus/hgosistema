
$(document).ready(function(){
	
	const modalHtmlAuditoria = `<div class='modal fade' id='modalAddAuditoria' tabindex='-1'>
		<div class='modal-dialog modal-lg'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>Detalle Auditoria</h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>×</span>
				</button>
			</div>
			<div class='modal-body'>
				<div class='form-group row'>
					<div class='col-6 form-group row' hidden>
						<label for = 'idauditoriaadd' class='col-sm-4'>Idauditoria:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='idauditoriaadd' name='idauditoriaadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-success btn-sm' id='btnAddModalAgregarAuditoria'>Agregar</button>
				<button type='button' class='btn btn-primary btn-sm' id='btnAddModalCerrarAuditoria' data-dismiss='modal'>Cerrar</button>
			</div>
			</div>
		</div>
	</div>`;
	$('body').append(modalHtmlAuditoria);
	
	var NuevoAuditoria;
	
	$('#btnAddAuditoria').click(function(){
		debugger
		LimpiarModalDatosAuditoriaAdd();
		$('#btnModalAddAuditoria').toggle(true);
		$('#modalAddAuditoria').modal();
	});
	
	$('#btnAddModalAgregarAuditoria').click(function(){
		if(ValidarCamposVaciosAuditoriaAdd() != 0)
		{
			alert('Completar campos obligatorios');
		}
		else
		{
			RecolectarDatosAuditoriaAdd();
			EnviarInformacionAuditoriaAdd('agregar', NuevoAuditoria, true);
		}
	});
	
	function EnviarInformacionAuditoriaAdd(accion, objEvento, modal, pag=1){
		$.ajax({
			type: 'POST',
			url: base_url+'/auditoria/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				debugger
				var resp = JSON.parse(msg);
				if (modal) {
					$('#modalAddAuditoria').modal('toggle');
					LimpiarModalDatosAuditoriaAdd();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								actualizarSelectAuditoriaAdd();
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
	function actualizarSelectAuditoriaAdd() {
		var nuevaOpcion = $('<option>', {
		});
		$('#idauditoria').append(nuevaOpcion);
		$('#idauditoria').val(NuevoAuditoria.idauditoria);
	};
	
	function RecolectarDatosAuditoriaAdd(){
		NuevoAuditoria = {
			estado: 1,
		};
	}
	
	function LimpiarModalDatosAuditoriaAdd(){
	}
	
	function ValidarCamposVaciosAuditoriaAdd(){
		var error = 0;
		return error;
	}
});
