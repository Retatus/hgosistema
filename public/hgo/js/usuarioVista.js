
$(document).ready(function(){
	
	const modalHtmlUsuario = `<div class='modal fade' id='modalAddUsuario' tabindex='-1'>
		<div class='modal-dialog modal-lg'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>Detalle Usuario</h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>×</span>
				</button>
			</div>
			<div class='modal-body'>
				<div class='form-group row'>
					<div class='col-6 form-group row' hidden>
						<label for = 'usuarioidadd' class='col-sm-4'>Usuarioid:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='usuarioidadd' name='usuarioidadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
					<div class='col-6 form-group row'>
						<label for = 'usuarionombreadd' class='col-sm-4' for='id'>Usuarionombre:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='usuarionombreadd' name='usuarionombreadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-success btn-sm' id='btnAddModalAgregarUsuario'>Agregar</button>
				<button type='button' class='btn btn-primary btn-sm' id='btnAddModalCerrarUsuario' data-dismiss='modal'>Cerrar</button>
			</div>
			</div>
		</div>
	</div>`;
	$('body').append(modalHtmlUsuario);
	
	var NuevoUsuario;
	
	$('#btnAddUsuario').click(function(){
		LimpiarModalDatosUsuarioAdd();
		$('#btnModalAddUsuario').toggle(true);
		$('#modalAddUsuario').modal();
	});
	
	$('#btnAddModalAgregarUsuario').click(function(){
		if(ValidarCamposVaciosUsuarioAdd() != 0)
		{
			alert('Completar campos obligatorios');
		}
		else
		{
			RecolectarDatosUsuarioAdd();
			EnviarInformacionUsuarioAdd('agregar', NuevoUsuario, true);
		}
	});
	
	function EnviarInformacionUsuarioAdd(accion, objEvento, modal, pag=1){
		$.ajax({
			type: 'POST',
			url: base_url+'/usuario/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
		debugger
				var resp = JSON.parse(msg);
				if (modal) {
					$('#modalAgregarUsuario').modal('toggle');
					LimpiarModalDatosUsuarioAdd();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								actualizarSelectUsuarioAdd();
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
	function actualizarSelectUsuarioAdd() {
		var nuevaOpcion = $('<option>', {
			value: NuevoUsuario.usuarioid,
			text: NuevoUsuario.usuarionombre,
		});
		$('#nusuarioid').append(nuevaOpcion);
		$('#nusuarioid').val(NuevoUsuario.nusuarioid);
	};
	
	function RecolectarDatosUsuarioAdd(){
		NuevoUsuario = {
			usuarioid: $('#usuarioidadd').val().toUpperCase(),
			usuarionombre: $('#usuarionombreadd').val().toUpperCase(),
			estado: 1,
		};
	}
	
	function LimpiarModalDatosUsuarioAdd(){
		$('#usuarioidadd').val('');
		$('#usuarionombreadd').val('');
	}
	
	function ValidarCamposVaciosUsuarioAdd(){
		var error = 0;
		if ($('#usuarioidadd').val() == ''){
			Resaltado('usuarioidadd');
			error++;
		}else{
			NoResaltado('usuarioidadd');
		}
		if ($('#usuarionombreadd').val() == ''){
			Resaltado('usuarionombreadd');
			error++;
		}else{
			NoResaltado('usuarionombreadd');
		}
		return error;
	}
});
