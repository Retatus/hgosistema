
$(document).ready(function(){
	
	const modalHtmlMarca = `<div class='modal fade' id='modalAddMarca' tabindex='-1'>
		<div class='modal-dialog modal-md'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>Detalle Marca</h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>×</span>
				</button>
			</div>
			<div class='modal-body'>
				<div class='form-group row'>
					<div class='col-12 form-group row' hidden>
						<label for = 'idmarcaadd' class='col-sm-4'>Idmarca:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='idmarcaadd' name='idmarcaadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
					<div class='col-12 form-group row'>
						<label for = 'nombremarcaadd' class='col-sm-4' for='id'>Nombremarca:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='nombremarcaadd' name='nombremarcaadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-success btn-sm' id='btnAddModalAgregarMarca'>Agregar</button>
				<button type='button' class='btn btn-primary btn-sm' id='btnAddModalCerrarMarca' data-dismiss='modal'>Cerrar</button>
			</div>
			</div>
		</div>
	</div>`;
	$('body').append(modalHtmlMarca);
	
	var NuevoMarca;
	
	$('#btnAddMarca').click(function(){
		debugger
		LimpiarModalDatosMarcaAdd();
		$('#btnModalAddMarca').toggle(true);
		$('#modalAddMarca').modal();
	});
	
	$('#btnAddModalAgregarMarca').click(function(){
		if(ValidarCamposVaciosMarcaAdd() != 0)
		{
			alert('Completar campos obligatorios');
		}
		else
		{
			RecolectarDatosMarcaAdd();
			EnviarInformacionMarcaAdd('agregar', NuevoMarca, true);
		}
	});
	
	function EnviarInformacionMarcaAdd(accion, objEvento, modal, pag=1){
		$.ajax({
			type: 'POST',
			url: base_url+'/marca/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				debugger
				var resp = JSON.parse(msg);
				if (modal) {
					$('#modalAddMarca').modal('toggle');
					LimpiarModalDatosMarcaAdd();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								actualizarSelectMarcaAdd();
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
	function actualizarSelectMarcaAdd() {
		var nuevaOpcion = $('<option>', {
			text: NuevoMarca.nombremarca,
		});
		$('#idmarca').append(nuevaOpcion);
		$('#idmarca').val(NuevoMarca.idmarca);
	};
	
	function RecolectarDatosMarcaAdd(){
		NuevoMarca = {
			nombremarca: $('#nombremarcaadd').val().toUpperCase(),
			estado: 1,
		};
	}
	
	function LimpiarModalDatosMarcaAdd(){
		$('#nombremarcaadd').val('');
	}
	
	function ValidarCamposVaciosMarcaAdd(){
		var error = 0;
		if ($('#nombremarcaadd').val() == ''){
			Resaltado('nombremarcaadd');
			error++;
		}else{
			NoResaltado('nombremarcaadd');
		}
		return error;
	}
});
