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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarMarca'>
									<span class='fa fa-plus'></span> Agregar
								</button>
								<a href='<?php echo base_url();?>marca/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>marca/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroMarca'>
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
							<table id='TablaMarca' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idmarca</th>
										<th>Nombremarca</th>
										<th>Estado</th>
										<th hidden>Concatenado</th>
										<th hidden>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $marca):?>
											<tr>
												<td hidden><?php echo $marca['idmarca'];?></td>
												<td><?php echo $marca['nombremarca'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($marca['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $marca['concatenado'];?></td>
												<td hidden><?php echo $marca['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarMarca('<?php echo $marca['idmarca'];?>')" class='btn btn-info btn-xs'>
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
						<div id='PaginadoMarca'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarMarca' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Marca</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row' hidden>
					<label for = idmarca class='col-sm-4'>Idmarca:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idmarca' name='idmarca' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = nombremarca class='col-sm-4' for='id'>Nombremarca:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nombremarca' name='nombremarca' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarMarca'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarMarca'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarMarca'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarMarca' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoMarca;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosMarca();
		EnviarInformacionMarca('leer', NuevoMarca, false, pag);
	}
	$('#btnAgregarMarca').click(function(){
		LimpiarModalDatosMarca();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarMarca').toggle(true);
		$('#btnModalEditarMarca').toggle(false);
		$('#btnModalEliminarMarca').toggle(false);
		$('#modalAgregarMarca').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarMarca(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/marca/edit',
			data: {idmarca: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosMarca();
				$('#idmarca').val(temp.idmarca);
				$('#nombremarca').val(temp.nombremarca);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarMarca').toggle(false);
				$('#btnModalEditarMarca').toggle(true);
				$('#btnModalEliminarMarca').toggle(true);
				$('#modalAgregarMarca').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarMarca').click(function(){
		debugger
		if (ValidarCamposVaciosMarca() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosMarca();
			EnviarInformacionMarca('agregar', NuevoMarca, true);
		}
	});
	$('#btnModalEditarMarca').click(function(){
		if (ValidarCamposVaciosMarca() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosMarca();
			EnviarInformacionMarca('modificar', NuevoMarca, true);
		}
	});
	$('#btnModalEliminarMarca').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosMarca();
			EnviarInformacionMarca('eliminar', NuevoMarca, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosMarca();
	});
	$('#btnFiltroMarca').click(function(){
		RecolectarDatosMarca();
		EnviarInformacionMarca('leer', NuevoMarca, false);
	});
	function Paginado(pag) {
		RecolectarDatosMarca();
		EnviarInformacionMarca('leer', NuevoMarca, false, pag);
	}
	function RecolectarDatosMarca(){
		NuevoMarca = {
			idmarca: $('#idmarca').val().toUpperCase(),
			nombremarca: $('#nombremarca').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionMarca(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/marca/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoMarca').empty();
				$('#PaginadoMarca').append(resp.pag);
				if (modal) {
					$('#modalAgregarMarca').modal('toggle');
					LimpiarModalDatosMarca();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaMarca(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaMarca(resp.datos)
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
	function LimpiarModalDatosMarca(){
		$('#idmarca').val('0');
		$('#nombremarca').val('');
	}
	function ValidarCamposVaciosMarca(){
		var error = 0;
		var value = $('#idmarca').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idmarca');
			error++;
		}else{
			NoResaltado('idmarca');
		}
		if ($('#nombremarca').val() == ''){
			Resaltado('nombremarca');
			error++;
		}else{
			NoResaltado('nombremarca');
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
	function CargartablaMarca(objeto){
		$('#TablaMarca tr').not($('#TablaMarca tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idmarca !== null ? value.idmarca : ''}</td>
				<td>${value.nombremarca !== null ? value.nombremarca : ''}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.concatenado !== null ? value.concatenado : ''}</td>
				<td hidden>${value.concatenadodetalle !== null ? value.concatenadodetalle : ''}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarMarca('${value.idmarca}')" class='btn btn-info btn-xs'>
							<span class='fa fa-pencil fa-xs'></span>
						</button>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaMarca tbody').append(fila);
		});
	}
</script>
