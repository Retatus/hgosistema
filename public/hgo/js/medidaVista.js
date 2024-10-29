
$(document).ready(function(){
	
	const modalHtmlMedida = `<div class='modal fade' id='modalAddMedida' tabindex='-1'>
		<div class='modal-dialog modal-md'>
			<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title'>Detalle Medida</h4>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					<span aria-hidden='true'>×</span>
				</button>
			</div>
			<div class='modal-body'>
				<div class='form-group row'>
					<div class='col-12 form-group row' hidden>
						<label for = 'idmedidaadd' class='col-sm-4'>Idmedida:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='idmedidaadd' name='idmedidaadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
					<div class='col-12 form-group row'>
						<label for = 'nombremedidaadd' class='col-sm-4' for='id'>Nombremedida:</label>
						<div class = 'col-sm-8'>
							<input type='text' class='form-control form-control-sm text-uppercase' id='nombremedidaadd' name='nombremedidaadd' placeholder='T001' autocomplete = 'off'>
						</div>
					</div>
				</div>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-success btn-sm' id='btnAddModalAgregarMedida'>Agregar</button>
				<button type='button' class='btn btn-primary btn-sm' id='btnAddModalCerrarMedida' data-dismiss='modal'>Cerrar</button>
			</div>
			</div>
		</div>
	</div>`;
	$('body').append(modalHtmlMedida);
	
	var NuevoMedida;
	
	$('#btnAddMedida').click(function(){
		debugger
		LimpiarModalDatosMedidaAdd();
		$('#btnModalAddMedida').toggle(true);
		$('#modalAddMedida').modal();
	});
	
	$('#btnAddModalAgregarMedida').click(function(){
		if(ValidarCamposVaciosMedidaAdd() != 0)
		{
			alert('Completar campos obligatorios');
		}
		else
		{
			RecolectarDatosMedidaAdd();
			EnviarInformacionMedidaAdd('agregar', NuevoMedida, true);
		}
	});
	
	function EnviarInformacionMedidaAdd(accion, objEvento, modal, pag=1){
		$.ajax({
			type: 'POST',
			url: base_url+'/medida/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				debugger
				var resp = JSON.parse(msg);
				if (modal) {
					$('#modalAddMedida').modal('toggle');
					LimpiarModalDatosMedidaAdd();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								actualizarSelectMedidaAdd();
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
	function actualizarSelectMedidaAdd() {
		$('#idmedida').find('option').remove();
		$.get(`${base_url}/medida/listaSelect2`, function(response) {
			$('#idmedida').append(`<option value='0'>-- SELECCIONAR1 --</option>`);
			data = JSON.parse(response);
			let ultimoItem = data[0].idmedida;
			$.each(data, function(index, item) {
				$('#idmedida').append($('<option>', {
				value: item.idmedida,
				text: item.nombremedida
				}));
			});
			$('#idmedida').select2();
			if (ultimoItem) {
				$('#idmedida').val(ultimoItem).trigger('change');
			}
		})
		.fail(function() {
			console.error('Error al obtener los datos');
		});
	};
	
	function RecolectarDatosMedidaAdd(){
		NuevoMedida = {
			nombremedida: $('#nombremedidaadd').val().toUpperCase(),
			estado: 1,
		};
	}
	
	function LimpiarModalDatosMedidaAdd(){
		$('#nombremedidaadd').val('');
	}
	
	function ValidarCamposVaciosMedidaAdd(){
		var error = 0;
		if ($('#nombremedidaadd').val() == ''){
			Resaltado('nombremedidaadd');
			error++;
		}else{
			NoResaltado('nombremedidaadd');
		}
		return error;
	}
});
