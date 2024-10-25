<div class='content-wrapper'>
	<section class='content-header'>
	</section>
	<section class='content'>
		<div class='row'>
			<div class='col-12'>
				<div class='card'>
					<div class='card-header'>
						<div class='row'>
							<div class='col-sm-8'>
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarMedida'>
									<span class='fa fa-plus'></span> Agregar
								</button>
								<a href='<?php echo base_url();?>medida/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>medida/pdf' target='_blank' class='btn btn-danger btn-sm'>
									<span class='fa fa-file-pdf-o'></span> Exportar
								</a>
							</div>
							<div class='col-sm-4'>
								<div class='d-flex flex-row'>
									<div class='p-2'>
										<input id='idFTexto' type='search' class='form-control form-control-sm' placeholder='Doc. | Nombre | Apellido'>
									</div>
									<div class='p-2'>
										<div class='input-group'>
											<select id='idFTodos' class='form-control form-control-sm'>
												<option value=''>TODOS</option>
												<option value='0'>DESCATIVOS</option>
												<option value='1' selected>ACTIVOS</option>
											</select>
											<span class='input-group-btn'>
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroMedida'>
													<span class='fa fa-filter'></span> Buscar
												</button>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class='card-body'>
						<div class='demo-content scroll'>
							<table id='TablaMedida' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idmedida</th>
										<th>Nombremedida</th>
										<th>Estado</th>
										<th hidden>Concatenado</th>
										<th hidden>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $medida):?>
											<tr>
												<td hidden><?php echo $medida['idmedida'];?></td>
												<td><?php echo $medida['nombremedida'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($medida['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $medida['concatenado'];?></td>
												<td hidden><?php echo $medida['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarMedida('<?php echo $medida['idmedida'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-pencil fa-xs'></span>
															</button>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
					</div>
					<div class='card-footer'>
						<div id='PaginadoMedida'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarMedida' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Medida</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row' hidden>
					<label for = idmedida class='col-sm-4'>Idmedida:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idmedida' name='idmedida' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = nombremedida class='col-sm-4' for='id'>Nombremedida:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nombremedida' name='nombremedida' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = estado class='col-sm-4' for='rol'>Estado:</label>
					<div class='col-sm-8'>
						<select class='form-control form-control-sm' id='estado' name='estado'>
							<option value = '1' selected >ACTIVO</option>
							<option value = '0' >DESACTIVO</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarMedida'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarMedida'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarMedida'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarMedida' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoMedida;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosMedida();
		EnviarInformacionMedida('leer', NuevoMedida, false, pag);
	}
	$('#btnAgregarMedida').click(function(){
		LimpiarModalDatosMedida();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarMedida').toggle(true);
		$('#btnModalEditarMedida').toggle(false);
		$('#btnModalEliminarMedida').toggle(false);
		$('#modalAgregarMedida').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarMedida(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/medida/edit',
			data: {idmedida: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosMedida();
				$('#idmedida').val(temp.idmedida);
				$('#nombremedida').val(temp.nombremedida);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarMedida').toggle(false);
				$('#btnModalEditarMedida').toggle(true);
				$('#btnModalEliminarMedida').toggle(true);
				$('#modalAgregarMedida').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarMedida').click(function(){
		debugger
		if (ValidarCamposVaciosMedida() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosMedida();
			EnviarInformacionMedida('agregar', NuevoMedida, true);
		}
	});
	$('#btnModalEditarMedida').click(function(){
		if (ValidarCamposVaciosMedida() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosMedida();
			EnviarInformacionMedida('modificar', NuevoMedida, true);
		}
	});
	$('#btnModalEliminarMedida').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosMedida();
			EnviarInformacionMedida('eliminar', NuevoMedida, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosMedida();
	});
	$('#btnFiltroMedida').click(function(){
		RecolectarDatosMedida();
		EnviarInformacionMedida('leer', NuevoMedida, false);
	});
	function Paginado(pag) {
		RecolectarDatosMedida();
		EnviarInformacionMedida('leer', NuevoMedida, false, pag);
	}
	function RecolectarDatosMedida(){
		NuevoMedida = {
			idmedida: $('#idmedida').val().toUpperCase(),
			nombremedida: $('#nombremedida').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionMedida(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/medida/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoMedida').empty();
				$('#PaginadoMedida').append(resp.pag);
				if (modal) {
					$('#modalAgregarMedida').modal('toggle');
					LimpiarModalDatosMedida();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaMedida(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaMedida(resp.datos)
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
	function LimpiarModalDatosMedida(){
		$('#idmedida').val('0');
		$('#nombremedida').val('');
	}
	function ValidarCamposVaciosMedida(){
		var error = 0;
		var value = $('#idmedida').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idmedida');
			error++;
		}else{
			NoResaltado('idmedida');
		}
		if ($('#nombremedida').val() == ''){
			Resaltado('nombremedida');
			error++;
		}else{
			NoResaltado('nombremedida');
		}
		if ($('#estado').val() == ''){
			Resaltado('estado');
			error++;
		}else{
			NoResaltado('estado');
		}
		return error;
	}
	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}

	function NoResaltado(id){
		$('#'+id).css('border-color', '#ced4da');
	}
	function CargartablaMedida(objeto){
		$('#TablaMedida tr').not($('#TablaMedida tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idmedida !== null ? value.idmedida : ''}</td>
				<td>${value.nombremedida !== null ? value.nombremedida : ''}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.concatenado !== null ? value.concatenado : ''}</td>
				<td hidden>${value.concatenadodetalle !== null ? value.concatenadodetalle : ''}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarMedida('${value.idmedida}')" class='btn btn-info btn-xs'>
							<span class='fa fa-pencil fa-xs'></span>
						</button>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaMedida tbody').append(fila);
		});
	}
</script>
