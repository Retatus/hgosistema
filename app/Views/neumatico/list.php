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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarNeumatico'>
									<span class='fa fa-plus'></span> Agregar Neumatico
								</button>
								<a href='<?php echo base_url();?>neumatico/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>neumatico/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroNeumatico'>
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
							<table id='TablaNeumatico' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idneumatico</th>
										<th>Nombreneumatico</th>
										<th>Estado</th>
										<th hidden>Concatenado</th>
										<th hidden>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $neumatico):?>
											<tr>
												<td hidden><?php echo $neumatico['idneumatico'];?></td>
												<td><?php echo $neumatico['nombreneumatico'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($neumatico['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $neumatico['concatenado'];?></td>
												<td hidden><?php echo $neumatico['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarNeumatico('<?php echo $neumatico['idneumatico'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-pencil fa-xs'></span>
															</button>
														</div>
														<?php if(intval(session()->get('user_rol')) === 1):?>
															<div style='margin: auto;'>
																<button type='button' onclick="btnVerAuditoria('<?php echo $neumatico['idneumatico'];?>')" class='btn btn-success btn-xs'>
																	<span class='fa fa-search fa-xs'></span>
																</button>
														<?php endif;?>
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
						<div id='PaginadoNeumatico'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarNeumatico' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Neumatico</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row' hidden>
					<label for = idneumatico class='col-sm-4'>Idneumatico:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idneumatico' name='idneumatico' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = nombreneumatico class='col-sm-4' for='id'>Nombreneumatico:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nombreneumatico' name='nombreneumatico' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarNeumatico'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarNeumatico'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarNeumatico'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarNeumatico' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoNeumatico;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosNeumatico();
		EnviarInformacionNeumatico('leer', NuevoNeumatico, false, pag);
	}
	$('#btnAgregarNeumatico').click(function(){
		LimpiarModalDatosNeumatico();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarNeumatico').toggle(true);
		$('#btnModalEditarNeumatico').toggle(false);
		$('#btnModalEliminarNeumatico').toggle(false);
		$('#modalAgregarNeumatico').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarNeumatico(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/neumatico/edit',
			data: {idneumatico: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosNeumatico();
				$('#idneumatico').val(temp.idneumatico);
				$('#nombreneumatico').val(temp.nombreneumatico);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarNeumatico').toggle(false);
				$('#btnModalEditarNeumatico').toggle(true);
				$('#btnModalEliminarNeumatico').toggle(true);
				$('#modalAgregarNeumatico').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarNeumatico').click(function(){
		debugger
		if (ValidarCamposVaciosNeumatico() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosNeumatico();
			EnviarInformacionNeumatico('agregar', NuevoNeumatico, true);
		}
	});
	$('#btnModalEditarNeumatico').click(function(){
		if (ValidarCamposVaciosNeumatico() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosNeumatico();
			EnviarInformacionNeumatico('modificar', NuevoNeumatico, true);
		}
	});
	$('#btnModalEliminarNeumatico').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosNeumatico();
			EnviarInformacionNeumatico('eliminar', NuevoNeumatico, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosNeumatico();
	});
	$('#btnFiltroNeumatico').click(function(){
		RecolectarDatosNeumatico();
		EnviarInformacionNeumatico('leer', NuevoNeumatico, false);
	});
	function Paginado(pag) {
		RecolectarDatosNeumatico();
		EnviarInformacionNeumatico('leer', NuevoNeumatico, false, pag);
	}
	function RecolectarDatosNeumatico(){
		NuevoNeumatico = {
			idneumatico: $('#idneumatico').val().toUpperCase(),
			nombreneumatico: $('#nombreneumatico').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionNeumatico(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/neumatico/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoNeumatico').empty();
				$('#PaginadoNeumatico').append(resp.pag);
				if (modal) {
					$('#modalAgregarNeumatico').modal('toggle');
					LimpiarModalDatosNeumatico();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaNeumatico(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaNeumatico(resp.datos)
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
	function LimpiarModalDatosNeumatico(){
		$('#idneumatico').val('0');
		$('#nombreneumatico').val('');
	}
	function ValidarCamposVaciosNeumatico(){
		var error = 0;
		var value = $('#idneumatico').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idneumatico');
			error++;
		}else{
			NoResaltado('idneumatico');
		}
		if ($('#nombreneumatico').val() == ''){
			Resaltado('nombreneumatico');
			error++;
		}else{
			NoResaltado('nombreneumatico');
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
	function CargartablaNeumatico(objeto){
		$('#TablaNeumatico tr').not($('#TablaNeumatico tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idneumatico !== null ? value.idneumatico : ''}</td>
				<td>${value.nombreneumatico !== null ? value.nombreneumatico : ''}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.concatenado !== null ? value.concatenado : ''}</td>
				<td hidden>${value.concatenadodetalle !== null ? value.concatenadodetalle : ''}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarNeumatico('${value.idneumatico}')" class='btn btn-info btn-xs'>
							<span class='fa fa-pencil fa-xs'></span>
						</button>
					</div>
						<?php if(intval(session()->get('user_rol')) === 1):?>
							<div style='margin: auto;'>
								<button type='button' onclick="btnVerAuditoria('${value.idservicio}')" class='btn btn-success btn-xs'>
									<span class='fa fa-search fa-xs'></span>
								</button>
							</div>
					<?php endif;?>
				</div>
				</td>
				</tr>`
			$('#TablaNeumatico tbody').append(fila);
		});
	}
</script>
