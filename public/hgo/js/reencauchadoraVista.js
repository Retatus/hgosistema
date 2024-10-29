
$(document).ready(function(){
	
	const modalHtmlReencauchadora = `<div class='modal fade' id='modalAddReencauchadora' tabindex='-1'>
		<div class='modal-dialog modal-md'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>Detalle Reencauchadora</h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>×</span>
				</button>
			</div>
			<div class='modal-body'>
				<div class='form-group row'>
					<div class='col-12 form-group row' hidden>
						<label for = 'idreencauchadoraadd' class='col-sm-4'>Idreencauchadora:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='idreencauchadoraadd' name='idreencauchadoraadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
					<div class='col-12 form-group row'>
						<label for = 'nombrereencauchadoraadd' class='col-sm-4' for='id'>Nombrereencauchadora:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='nombrereencauchadoraadd' name='nombrereencauchadoraadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-success btn-sm' id='btnAddModalAgregarReencauchadora'>Agregar</button>
				<button type='button' class='btn btn-primary btn-sm' id='btnAddModalCerrarReencauchadora' data-dismiss='modal'>Cerrar</button>
			</div>
			</div>
		</div>
	</div>`;
	$('body').append(modalHtmlReencauchadora);
	
	var NuevoReencauchadora;
	
	$('#btnAddReencauchadora').click(function(){
		debugger
		LimpiarModalDatosReencauchadoraAdd();
		$('#btnModalAddReencauchadora').toggle(true);
		$('#modalAddReencauchadora').modal();
	});
	
	$('#btnAddModalAgregarReencauchadora').click(function(){
		if(ValidarCamposVaciosReencauchadoraAdd() != 0)
		{
			alert('Completar campos obligatorios');
		}
		else
		{
			RecolectarDatosReencauchadoraAdd();
			EnviarInformacionReencauchadoraAdd('agregar', NuevoReencauchadora, true);
		}
	});
	
	function EnviarInformacionReencauchadoraAdd(accion, objEvento, modal, pag=1){
		$.ajax({
			type: 'POST',
			url: base_url+'/reencauchadora/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				debugger
				var resp = JSON.parse(msg);
				if (modal) {
					$('#modalAddReencauchadora').modal('toggle');
					LimpiarModalDatosReencauchadoraAdd();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								actualizarSelectReencauchadoraAdd();
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
	function actualizarSelectReencauchadoraAdd() {
		$('#idreencauchadora').find('option').remove();
		$.get(`${base_url}/reencauchadora/listaSelect2`, function(response) {
			$('#idreencauchadora').append(`<option value='0'>-- SELECCIONAR1 --</option>`);
			data = JSON.parse(response);
			let ultimoItem = data[0].idreencauchadora;
			$.each(data, function(index, item) {
				$('#idreencauchadora').append($('<option>', {
				value: item.idreencauchadora,
				text: item.nombrereencauchadora
				}));
			});
			$('#idreencauchadora').select2();
			if (ultimoItem) {
				$('#idreencauchadora').val(ultimoItem).trigger('change');
			}
		})
		.fail(function() {
			console.error('Error al obtener los datos');
		});
	};
	
	function RecolectarDatosReencauchadoraAdd(){
		NuevoReencauchadora = {
			nombrereencauchadora: $('#nombrereencauchadoraadd').val().toUpperCase(),
			estado: 1,
		};
	}
	
	function LimpiarModalDatosReencauchadoraAdd(){
		$('#nombrereencauchadoraadd').val('');
	}
	
	function ValidarCamposVaciosReencauchadoraAdd(){
		var error = 0;
		if ($('#nombrereencauchadoraadd').val() == ''){
			Resaltado('nombrereencauchadoraadd');
			error++;
		}else{
			NoResaltado('nombrereencauchadoraadd');
		}
		return error;
	}
});
