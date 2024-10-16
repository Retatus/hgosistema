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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarReencauchadora'>
									<span class='fa fa-plus'></span> Agregar Reencauchadora
								</button>
								<a href='<?php echo base_url();?>reencauchadora/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>reencauchadora/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroReencauchadora'>
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
							<table id='TablaReencauchadora' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idrencauchadora</th>
										<th>Nombrereencauchadora</th>
										<th>Direccion</th>
										<th>Estado</th>
										<th hidden>Concatenado</th>
										<th hidden>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $reencauchadora):?>
											<tr>
												<td hidden><?php echo $reencauchadora['idrencauchadora'];?></td>
												<td><?php echo $reencauchadora['nombrereencauchadora'];?></td>
												<td><?php echo $reencauchadora['direccion'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($reencauchadora['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $reencauchadora['concatenado'];?></td>
												<td hidden><?php echo $reencauchadora['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarReencauchadora('<?php echo $reencauchadora['idrencauchadora'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-pencil fa-xs'></span>
															</button>
														</div>
														<?php if(intval(session()->get('user_rol')) === 1):?>
															<div style='margin: auto;'>
																<a class='btn btn-success btn-xs' href="<?php echo base_url();?>auditoria/getAuditoria/<?php echo $reencauchadora['idrencauchadora'];?>"><i class='fa fa-search'></i></a>
															</div>
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
						<div id='PaginadoReencauchadora'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarReencauchadora' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Reencauchadora</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row' hidden>
					<label for = idrencauchadora class='col-sm-4'>Idrencauchadora:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idrencauchadora' name='idrencauchadora' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = nombrereencauchadora class='col-sm-4' for='id'>Nombrereencauchadora:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nombrereencauchadora' name='nombrereencauchadora' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = direccion class='col-sm-4' for='id'>Direccion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='direccion' name='direccion' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarReencauchadora'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarReencauchadora'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarReencauchadora'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarReencauchadora' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoReencauchadora;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosReencauchadora();
		EnviarInformacionReencauchadora('leer', NuevoReencauchadora, false, pag);
	}
	$('#btnAgregarReencauchadora').click(function(){
		LimpiarModalDatosReencauchadora();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarReencauchadora').toggle(true);
		$('#btnModalEditarReencauchadora').toggle(false);
		$('#btnModalEliminarReencauchadora').toggle(false);
		$('#modalAgregarReencauchadora').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarReencauchadora(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/reencauchadora/edit',
			data: {idrencauchadora: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosReencauchadora();
				$('#idrencauchadora').val(temp.idrencauchadora);
				$('#nombrereencauchadora').val(temp.nombrereencauchadora);
				$('#direccion').val(temp.direccion);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarReencauchadora').toggle(false);
				$('#btnModalEditarReencauchadora').toggle(true);
				$('#btnModalEliminarReencauchadora').toggle(true);
				$('#modalAgregarReencauchadora').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarReencauchadora').click(function(){
		debugger
		if (ValidarCamposVaciosReencauchadora() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosReencauchadora();
			EnviarInformacionReencauchadora('agregar', NuevoReencauchadora, true);
		}
	});
	$('#btnModalEditarReencauchadora').click(function(){
		if (ValidarCamposVaciosReencauchadora() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosReencauchadora();
			EnviarInformacionReencauchadora('modificar', NuevoReencauchadora, true);
		}
	});
	$('#btnModalEliminarReencauchadora').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosReencauchadora();
			EnviarInformacionReencauchadora('eliminar', NuevoReencauchadora, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosReencauchadora();
	});
	$('#btnFiltroReencauchadora').click(function(){
		RecolectarDatosReencauchadora();
		EnviarInformacionReencauchadora('leer', NuevoReencauchadora, false);
	});
	function Paginado(pag) {
		RecolectarDatosReencauchadora();
		EnviarInformacionReencauchadora('leer', NuevoReencauchadora, false, pag);
	}
	function RecolectarDatosReencauchadora(){
		NuevoReencauchadora = {
			idrencauchadora: $('#idrencauchadora').val().toUpperCase(),
			nombrereencauchadora: $('#nombrereencauchadora').val().toUpperCase(),
			direccion: $('#direccion').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionReencauchadora(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/reencauchadora/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoReencauchadora').empty();
				$('#PaginadoReencauchadora').append(resp.pag);
				if (modal) {
					$('#modalAgregarReencauchadora').modal('toggle');
					LimpiarModalDatosReencauchadora();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaReencauchadora(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaReencauchadora(resp.datos)
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
	function LimpiarModalDatosReencauchadora(){
		$('#idrencauchadora').val('0');
		$('#nombrereencauchadora').val('');
		$('#direccion').val('');
	}
	function ValidarCamposVaciosReencauchadora(){
		var error = 0;
		var value = $('#idrencauchadora').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idrencauchadora');
			error++;
		}else{
			NoResaltado('idrencauchadora');
		}
		if ($('#nombrereencauchadora').val() == ''){
			Resaltado('nombrereencauchadora');
			error++;
		}else{
			NoResaltado('nombrereencauchadora');
		}
		if ($('#direccion').val() == ''){
			Resaltado('direccion');
			error++;
		}else{
			NoResaltado('direccion');
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
	function CargartablaReencauchadora(objeto){
		$('#TablaReencauchadora tr').not($('#TablaReencauchadora tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idrencauchadora !== null ? value.idrencauchadora : ''}</td>
				<td>${value.nombrereencauchadora !== null ? value.nombrereencauchadora : ''}</td>
				<td>${value.direccion !== null ? value.direccion : ''}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.concatenado !== null ? value.concatenado : ''}</td>
				<td hidden>${value.concatenadodetalle !== null ? value.concatenadodetalle : ''}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarReencauchadora('${value.idrencauchadora}')" class='btn btn-info btn-xs'>
							<span class='fa fa-pencil fa-xs'></span>
						</button>
					</div>
						<?php if(intval(session()->get('user_rol')) === 1):?>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/auditoria/getAuditoria/<?php echo $reencauchadora['idrencauchadora'];?>'><i class='fa fa-search'></i></a>
						</div>
					<?php endif;?>
				</div>
				</td>
				</tr>`
			$('#TablaReencauchadora tbody').append(fila);
		});
	}
</script>
