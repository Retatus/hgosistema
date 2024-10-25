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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarNumero'>
									<span class='fa fa-plus'></span> Agregar
								</button>
								<a href='<?php echo base_url();?>numero/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>numero/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroNumero'>
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
							<table id='TablaNumero' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idnumero</th>
										<th>Nombrenumero</th>
										<th>Estado</th>
										<th hidden>Concatenado</th>
										<th hidden>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $numero):?>
											<tr>
												<td hidden><?php echo $numero['idnumero'];?></td>
												<td><?php echo $numero['nombrenumero'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($numero['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $numero['concatenado'];?></td>
												<td hidden><?php echo $numero['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarNumero('<?php echo $numero['idnumero'];?>')" class='btn btn-info btn-xs'>
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
						<div id='PaginadoNumero'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarNumero' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Numero</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row' hidden>
					<label for = idnumero class='col-sm-4'>Idnumero:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idnumero' name='idnumero' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = nombrenumero class='col-sm-4' for='id'>Nombrenumero:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nombrenumero' name='nombrenumero' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarNumero'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarNumero'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarNumero'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarNumero' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoNumero;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosNumero();
		EnviarInformacionNumero('leer', NuevoNumero, false, pag);
	}
	$('#btnAgregarNumero').click(function(){
		LimpiarModalDatosNumero();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarNumero').toggle(true);
		$('#btnModalEditarNumero').toggle(false);
		$('#btnModalEliminarNumero').toggle(false);
		$('#modalAgregarNumero').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarNumero(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/numero/edit',
			data: {idnumero: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosNumero();
				$('#idnumero').val(temp.idnumero);
				$('#nombrenumero').val(temp.nombrenumero);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarNumero').toggle(false);
				$('#btnModalEditarNumero').toggle(true);
				$('#btnModalEliminarNumero').toggle(true);
				$('#modalAgregarNumero').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarNumero').click(function(){
		debugger
		if (ValidarCamposVaciosNumero() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosNumero();
			EnviarInformacionNumero('agregar', NuevoNumero, true);
		}
	});
	$('#btnModalEditarNumero').click(function(){
		if (ValidarCamposVaciosNumero() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosNumero();
			EnviarInformacionNumero('modificar', NuevoNumero, true);
		}
	});
	$('#btnModalEliminarNumero').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosNumero();
			EnviarInformacionNumero('eliminar', NuevoNumero, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosNumero();
	});
	$('#btnFiltroNumero').click(function(){
		RecolectarDatosNumero();
		EnviarInformacionNumero('leer', NuevoNumero, false);
	});
	function Paginado(pag) {
		RecolectarDatosNumero();
		EnviarInformacionNumero('leer', NuevoNumero, false, pag);
	}
	function RecolectarDatosNumero(){
		NuevoNumero = {
			idnumero: $('#idnumero').val().toUpperCase(),
			nombrenumero: $('#nombrenumero').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionNumero(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/numero/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoNumero').empty();
				$('#PaginadoNumero').append(resp.pag);
				if (modal) {
					$('#modalAgregarNumero').modal('toggle');
					LimpiarModalDatosNumero();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaNumero(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaNumero(resp.datos)
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
	function LimpiarModalDatosNumero(){
		$('#idnumero').val('0');
		$('#nombrenumero').val('');
	}
	function ValidarCamposVaciosNumero(){
		var error = 0;
		var value = $('#idnumero').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idnumero');
			error++;
		}else{
			NoResaltado('idnumero');
		}
		if ($('#nombrenumero').val() == ''){
			Resaltado('nombrenumero');
			error++;
		}else{
			NoResaltado('nombrenumero');
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
	function CargartablaNumero(objeto){
		$('#TablaNumero tr').not($('#TablaNumero tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idnumero !== null ? value.idnumero : ''}</td>
				<td>${value.nombrenumero !== null ? value.nombrenumero : ''}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.concatenado !== null ? value.concatenado : ''}</td>
				<td hidden>${value.concatenadodetalle !== null ? value.concatenadodetalle : ''}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarNumero('${value.idnumero}')" class='btn btn-info btn-xs'>
							<span class='fa fa-pencil fa-xs'></span>
						</button>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaNumero tbody').append(fila);
		});
	}
</script>
