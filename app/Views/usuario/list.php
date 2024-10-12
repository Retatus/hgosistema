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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarUsuario'>
									<span class='fa fa-plus'></span> Agregar Usuario
								</button>
								<a href='<?php echo base_url();?>usuario/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>usuario/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroUsuario'>
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
							<table id='TablaUsuario' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th>Idusuario</th>
										<th>Nombreusuario</th>
										<th>Estado</th>
										<th>Concatenado</th>
										<th>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $usuario):?>
											<tr>
												<td><?php echo $usuario['idusuario'];?></td>
												<td><?php echo $usuario['nombreusuario'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($usuario['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td><?php echo $usuario['concatenado'];?></td>
												<td><?php echo $usuario['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarUsuario('<?php echo $usuario['idusuario'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $usuario['idusuario'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoUsuario'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarUsuario' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Usuario</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row'>
					<label for = idusuario class='col-sm-4'>Idusuario:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idusuario' name='idusuario' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = nombreusuario class='col-sm-4' for='id'>Nombreusuario:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nombreusuario' name='nombreusuario' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarUsuario'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarUsuario'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarUsuario'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarUsuario' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoUsuario;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosUsuario();
		EnviarInformacionUsuario('leer', NuevoUsuario, false, pag);
	}
	$('#btnAgregarUsuario').click(function(){
		LimpiarModalDatosUsuario();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarUsuario').toggle(true);
		$('#btnModalEditarUsuario').toggle(false);
		$('#btnModalEliminarUsuario').toggle(false);
		$('#modalAgregarUsuario').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarUsuario(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/usuario/edit',
			data: {idusuario: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosUsuario();
				$('#idusuario').val(temp.idusuario);
				$('#nombreusuario').val(temp.nombreusuario);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarUsuario').toggle(false);
				$('#btnModalEditarUsuario').toggle(true);
				$('#btnModalEliminarUsuario').toggle(true);
				$('#modalAgregarUsuario').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarUsuario').click(function(){
		debugger
		if (ValidarCamposVaciosUsuario() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosUsuario();
			EnviarInformacionUsuario('agregar', NuevoUsuario, true);
		}
	});
	$('#btnModalEditarUsuario').click(function(){
		if (ValidarCamposVaciosUsuario() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosUsuario();
			EnviarInformacionUsuario('modificar', NuevoUsuario, true);
		}
	});
	$('#btnModalEliminarUsuario').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosUsuario();
			EnviarInformacionUsuario('eliminar', NuevoUsuario, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosUsuario();
	});
	$('#btnFiltroUsuario').click(function(){
		RecolectarDatosUsuario();
		EnviarInformacionUsuario('leer', NuevoUsuario, false);
	});
	function Paginado(pag) {
		RecolectarDatosUsuario();
		EnviarInformacionUsuario('leer', NuevoUsuario, false, pag);
	}
	function RecolectarDatosUsuario(){
		NuevoUsuario = {
			idusuario: $('#idusuario').val().toUpperCase(),
			nombreusuario: $('#nombreusuario').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionUsuario(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/usuario/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoUsuario').empty();
				$('#PaginadoUsuario').append(resp.pag);
				if (modal) {
					$('#modalAgregarUsuario').modal('toggle');
					LimpiarModalDatosUsuario();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaUsuario(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaUsuario(resp.datos)
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
	function LimpiarModalDatosUsuario(){
		$('#idusuario').val('');
		$('#nombreusuario').val('');
	}
	function ValidarCamposVaciosUsuario(){
		var error = 0;
		if ($('#idusuario').val() == ''){
			Resaltado('idusuario');
			error++;
		}else{
			NoResaltado('idusuario');
		}
		if ($('#nombreusuario').val() == ''){
			Resaltado('nombreusuario');
			error++;
		}else{
			NoResaltado('nombreusuario');
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
	function CargartablaUsuario(objeto){
		$('#TablaUsuario tr').not($('#TablaUsuario tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td>${value.idusuario !== null ? value.idusuario : ''}</td>
				<td>${value.nombreusuario !== null ? value.nombreusuario : ''}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td>${value.concatenado !== null ? value.concatenado : ''}</td>
				<td>${value.concatenadodetalle !== null ? value.concatenadodetalle : ''}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarUsuario('${value.idusuario}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$usuario['idusuario']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaUsuario tbody').append(fila);
		});
	}
</script>
