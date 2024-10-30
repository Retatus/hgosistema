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
									<span class='fa fa-plus'></span> Agregar
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
										<th hidden>Usuarioid</th>
										<th>Usuarionrodoc</th>
										<th>Usuariotipodoc</th>
										<th>Usuarionombre</th>
										<th>Usuariotelefono</th>
										<th>Usuariopassword</th>
										<th>Usuariotiporol</th>
										<th>Usuarioestado</th>
										<th hidden>Concatenado</th>
										<th hidden>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $usuario):?>
											<tr>
												<td hidden><?php echo $usuario['usuarioid'];?></td>
												<td><?php echo $usuario['usuarionrodoc'];?></td>
												<td><?php echo $usuario['usuariotipodoc'];?></td>
												<td><?php echo $usuario['usuarionombre'];?></td>
												<td><?php echo $usuario['usuariotelefono'];?></td>
												<td><?php echo $usuario['usuariopassword'];?></td>
												<td><?php echo $usuario['usuariotiporol'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($usuario['usuarioestado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $usuario['concatenado'];?></td>
												<td hidden><?php echo $usuario['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarUsuario('<?php echo $usuario['usuarioid'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-pencil fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a href="#" class="btn btn-danger btn-xs" onclick="return confirmarAlter(<?= $usuario['usuarioid']; ?>);">
																<i class="fa fa-pencil"></i>
															</a>
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
				<div class='col-6 form-group row' hidden>
					<label for = usuarioid class='col-sm-4'>Usuarioid:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='usuarioid' name='usuarioid' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = usuarionrodoc class='col-sm-4' for='id'>Usuarionrodoc:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='usuarionrodoc' name='usuarionrodoc' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = usuariotipodoc class='col-sm-4' for='id'>Usuariotipodoc:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='usuariotipodoc' name='usuariotipodoc' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = usuarionombre class='col-sm-4' for='id'>Usuarionombre:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='usuarionombre' name='usuarionombre' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = usuariotelefono class='col-sm-4' for='id'>Usuariotelefono:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='usuariotelefono' name='usuariotelefono' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row' hidden>
					<label for = usuariopassword class='col-sm-4' for='id'>Usuariopassword:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='usuariopassword' name='usuariopassword' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = usuariotiporol class='col-sm-4' for='id'>Usuariotiporol:</label>
					<div class = 'col-sm-8'>
						<input type='number' class='form-control form-control-sm' id='usuariotiporol' name='usuariotiporol' placeholder='0.00' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = usuarioestado class='col-sm-4' for='rol'>Usuarioestado:</label>
					<div class='col-sm-8'>
						<select class='form-control form-control-sm' id='usuarioestado' name='usuarioestado'>
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
<script type="text/javascript">
        function confirmarAlter(usuarioid) {
            if(confirm("¿Estás seguro de reestablecer la contraseña?")){
				$.ajax({
					url: `<?= base_url(); ?>/usuario/reestablecer/${usuarioid}`,
					type: 'GET',
					dataType: 'json',
					success: function(response) {
						debugger
						alert(response.message);
					},
					error: function() {
						alert("Ocurrió un error al intentar restablecer la contraseña.");
					}
				});
				return false; // Evita que el enlace realice la redirección
			}
			return false;
        }
    </script>
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
			data: {usuarioid: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosUsuario();
				$('#usuarioid').val(temp.usuarioid);
				$('#usuarionrodoc').val(temp.usuarionrodoc);
				$('#usuariotipodoc').val(temp.usuariotipodoc);
				$('#usuarionombre').val(temp.usuarionombre);
				$('#usuariotelefono').val(temp.usuariotelefono);
				$('#usuariopassword').val(temp.usuariopassword);
				$('#usuariotiporol').val(temp.usuariotiporol);
				$('#usuarioestado').val(temp.usuarioestado);
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
			usuarioid: $('#usuarioid').val().toUpperCase(),
			usuarionrodoc: $('#usuarionrodoc').val().toUpperCase(),
			usuariotipodoc: $('#usuariotipodoc').val().toUpperCase(),
			usuarionombre: $('#usuarionombre').val().toUpperCase(),
			usuariotelefono: $('#usuariotelefono').val().toUpperCase(),
			//usuariopassword: $('#usuariopassword').val().toUpperCase(),
			usuariotiporol: $('#usuariotiporol').val().toUpperCase(),
			usuarioestado: $('#usuarioestado').val().toUpperCase(),
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
		$('#usuarioid').val('0');
		$('#usuarionrodoc').val('');
		$('#usuariotipodoc').val('');
		$('#usuarionombre').val('');
		$('#usuariotelefono').val('');
		$('#usuariopassword').val('');
		$('#usuariotiporol').val('0');
	}
	function ValidarCamposVaciosUsuario(){
		var error = 0;
		var value = $('#usuarioid').val();
		if (!/^\d*$/.test(value)){
			Resaltado('usuarioid');
			error++;
		}else{
			NoResaltado('usuarioid');
		}
		if ($('#usuarionrodoc').val() == ''){
			Resaltado('usuarionrodoc');
			error++;
		}else{
			NoResaltado('usuarionrodoc');
		}
		if ($('#usuariotipodoc').val() == ''){
			Resaltado('usuariotipodoc');
			error++;
		}else{
			NoResaltado('usuariotipodoc');
		}
		if ($('#usuarionombre').val() == ''){
			Resaltado('usuarionombre');
			error++;
		}else{
			NoResaltado('usuarionombre');
		}
		if ($('#usuariotelefono').val() == ''){
			Resaltado('usuariotelefono');
			error++;
		}else{
			NoResaltado('usuariotelefono');
		}
		// if ($('#usuariopassword').val() == ''){
		// 	Resaltado('usuariopassword');
		// 	error++;
		// }else{
		// 	NoResaltado('usuariopassword');
		// }
		var value = $('#usuariotiporol').val();
		if (!/^\d*$/.test(value)){
			Resaltado('usuariotiporol');
			error++;
		}else{
			NoResaltado('usuariotiporol');
		}
		if ($('#usuarioestado').val() == ''){
			Resaltado('usuarioestado');
			error++;
		}else{
			NoResaltado('usuarioestado');
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
				<td hidden>${value.usuarioid !== null ? value.usuarioid : ''}</td>
				<td>${value.usuarionrodoc !== null ? value.usuarionrodoc : ''}</td>
				<td>${value.usuariotipodoc !== null ? value.usuariotipodoc : ''}</td>
				<td>${value.usuarionombre !== null ? value.usuarionombre : ''}</td>
				<td>${value.usuariotelefono !== null ? value.usuariotelefono : ''}</td>
				<td>${value.usuariopassword !== null ? value.usuariopassword : ''}</td>
				<td>${value.usuariotiporol !== null ? value.usuariotiporol : ''}</td>
				<td class = 'hidden-xs'>${value.usuarioestado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.concatenado !== null ? value.concatenado : ''}</td>
				<td hidden>${value.concatenadodetalle !== null ? value.concatenadodetalle : ''}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarUsuario('${value.usuarioid}')" class='btn btn-info btn-xs'>
							<span class='fa fa-pencil fa-xs'></span>
						</button>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaUsuario tbody').append(fila);
		});
	}
</script>
