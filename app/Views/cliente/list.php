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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarCliente'>
									<span class='fa fa-plus'></span> Agregar Cliente
								</button>
								<a href='<?php echo base_url();?>cliente/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>cliente/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroCliente'>
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
							<table id='TablaCliente' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th>Idcliente</th>
										<th>Nombrecliente</th>
										<th>Direccion</th>
										<th>Telefono</th>
										<th>Estado</th>
										<th hidden>Concatenado</th>
										<th hidden>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $cliente):?>
											<tr>
												<td><?php echo $cliente['idcliente'];?></td>
												<td><?php echo $cliente['nombrecliente'];?></td>
												<td><?php echo $cliente['direccion'];?></td>
												<td><?php echo $cliente['telefono'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($cliente['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $cliente['concatenado'];?></td>
												<td hidden><?php echo $cliente['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarCliente('<?php echo $cliente['idcliente'];?>')" class='btn btn-info btn-xs'>
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
						<div id='PaginadoCliente'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarCliente' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Cliente</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label for = idcliente class='col-sm-4'>Idcliente:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idcliente' name='idcliente' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = nombrecliente class='col-sm-4' for='id'>Nombrecliente:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nombrecliente' name='nombrecliente' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = direccion class='col-sm-4' for='id'>Direccion:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='direccion' name='direccion' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = telefono class='col-sm-4' for='id'>Telefono:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='telefono' name='telefono' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarCliente'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarCliente'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarCliente'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarCliente' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoCliente;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosCliente();
		EnviarInformacionCliente('leer', NuevoCliente, false, pag);
	}
	$('#btnAgregarCliente').click(function(){
		LimpiarModalDatosCliente();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarCliente').toggle(true);
		$('#btnModalEditarCliente').toggle(false);
		$('#btnModalEliminarCliente').toggle(false);
		$('#modalAgregarCliente').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarCliente(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/cliente/edit',
			data: {idcliente: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosCliente();
				$('#idcliente').val(temp.idcliente);
				$('#nombrecliente').val(temp.nombrecliente);
				$('#direccion').val(temp.direccion);
				$('#telefono').val(temp.telefono);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarCliente').toggle(false);
				$('#btnModalEditarCliente').toggle(true);
				$('#btnModalEliminarCliente').toggle(true);
				$('#modalAgregarCliente').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarCliente').click(function(){
		debugger
		if (ValidarCamposVaciosCliente() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosCliente();
			EnviarInformacionCliente('agregar', NuevoCliente, true);
		}
	});
	$('#btnModalEditarCliente').click(function(){
		if (ValidarCamposVaciosCliente() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosCliente();
			EnviarInformacionCliente('modificar', NuevoCliente, true);
		}
	});
	$('#btnModalEliminarCliente').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosCliente();
			EnviarInformacionCliente('eliminar', NuevoCliente, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosCliente();
	});
	$('#btnFiltroCliente').click(function(){
		RecolectarDatosCliente();
		EnviarInformacionCliente('leer', NuevoCliente, false);
	});
	function Paginado(pag) {
		RecolectarDatosCliente();
		EnviarInformacionCliente('leer', NuevoCliente, false, pag);
	}
	function RecolectarDatosCliente(){
		NuevoCliente = {
			idcliente: $('#idcliente').val().toUpperCase(),
			nombrecliente: $('#nombrecliente').val().toUpperCase(),
			direccion: $('#direccion').val().toUpperCase(),
			telefono: $('#telefono').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionCliente(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/cliente/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoCliente').empty();
				$('#PaginadoCliente').append(resp.pag);
				if (modal) {
					$('#modalAgregarCliente').modal('toggle');
					LimpiarModalDatosCliente();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaCliente(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaCliente(resp.datos)
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
	function LimpiarModalDatosCliente(){
		$('#idcliente').val('');
		$('#nombrecliente').val('');
		$('#direccion').val('');
		$('#telefono').val('');
	}
	function ValidarCamposVaciosCliente(){
		var error = 0;
		if ($('#idcliente').val() == ''){
			Resaltado('idcliente');
			error++;
		}else{
			NoResaltado('idcliente');
		}
		if ($('#nombrecliente').val() == ''){
			Resaltado('nombrecliente');
			error++;
		}else{
			NoResaltado('nombrecliente');
		}
		if ($('#direccion').val() == ''){
			Resaltado('direccion');
			error++;
		}else{
			NoResaltado('direccion');
		}
		if ($('#telefono').val() == ''){
			Resaltado('telefono');
			error++;
		}else{
			NoResaltado('telefono');
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
	function CargartablaCliente(objeto){
		$('#TablaCliente tr').not($('#TablaCliente tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td>${value.idcliente !== null ? value.idcliente : ''}</td>
				<td>${value.nombrecliente !== null ? value.nombrecliente : ''}</td>
				<td>${value.direccion !== null ? value.direccion : ''}</td>
				<td>${value.telefono !== null ? value.telefono : ''}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.concatenado !== null ? value.concatenado : ''}</td>
				<td hidden>${value.concatenadodetalle !== null ? value.concatenadodetalle : ''}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarCliente('${value.idcliente}')" class='btn btn-info btn-xs'>
							<span class='fa fa-pencil fa-xs'></span>
						</button>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaCliente tbody').append(fila);
		});
	}
</script>
