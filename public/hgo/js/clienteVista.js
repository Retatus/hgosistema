
$(document).ready(function(){
	
	const modalHtmlCliente = `<div class='modal fade' id='modalAddCliente' tabindex='-1'>
		<div class='modal-dialog modal-lg'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>Detalle Cliente</h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>×</span>
				</button>
			</div>
			<div class='modal-body'>
				<div class='form-group row'>
					<div class='col-6 form-group row'>
						<label for = 'idclienteadd' class='col-sm-4'>Idcliente:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='idclienteadd' name='idclienteadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
					<div class='col-6 form-group row'>
						<label for = 'nombreclienteadd' class='col-sm-4' for='id'>Nombrecliente:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='nombreclienteadd' name='nombreclienteadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-success btn-sm' id='btnAddModalAgregarCliente'>Agregar</button>
				<button type='button' class='btn btn-primary btn-sm' id='btnAddModalCerrarCliente' data-dismiss='modal'>Cerrar</button>
			</div>
			</div>
		</div>
	</div>`;
	$('body').append(modalHtmlCliente);
	
	var NuevoCliente;
	
	$('#btnAddCliente').click(function(){
		LimpiarModalDatosClienteAdd();
		$('#btnModalAddCliente').toggle(true);
		$('#modalAddCliente').modal();
	});
	
	$('#btnAddModalAgregarCliente').click(function(){
		if(ValidarCamposVaciosClienteAdd() != 0)
		{
			alert('Completar campos obligatorios');
		}
		else
		{
			RecolectarDatosClienteAdd();
			EnviarInformacionClienteAdd('agregar', NuevoCliente, true);
		}
	});
	
	function EnviarInformacionClienteAdd(accion, objEvento, modal, pag=1){
		$.ajax({
			type: 'POST',
			url: base_url+'/cliente/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
		debugger
				var resp = JSON.parse(msg);
				if (modal) {
					$('#modalAgregarCliente').modal('toggle');
					LimpiarModalDatosClienteAdd();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								actualizarSelectClienteAdd();
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
	function actualizarSelectClienteAdd() {
		var nuevaOpcion = $('<option>', {
			value: NuevoCliente.idcliente,
			text: NuevoCliente.nombrecliente,
		});
		$('#sidcliente').append(nuevaOpcion);
		$('#sidcliente').val(NuevoCliente.sidcliente);
	};
	
	function RecolectarDatosClienteAdd(){
		NuevoCliente = {
			idcliente: $('#idclienteadd').val().toUpperCase(),
			nombrecliente: $('#nombreclienteadd').val().toUpperCase(),
			estado: 1,
		};
	}
	
	function LimpiarModalDatosClienteAdd(){
		$('#idclienteadd').val('');
		$('#nombreclienteadd').val('');
	}
	
	function ValidarCamposVaciosClienteAdd(){
		var error = 0;
		if ($('#idclienteadd').val() == ''){
			Resaltado('idclienteadd');
			error++;
		}else{
			NoResaltado('idclienteadd');
		}
		if ($('#nombreclienteadd').val() == ''){
			Resaltado('nombreclienteadd');
			error++;
		}else{
			NoResaltado('nombreclienteadd');
		}
		return error;
	}
});
