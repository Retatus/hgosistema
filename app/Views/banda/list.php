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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarBanda'>
									<span class='fa fa-plus'></span> Agregar Banda
								</button>
								<a href='<?php echo base_url();?>banda/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>banda/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroBanda'>
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
							<table id='TablaBanda' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idbanda</th>
										<th>Nombrebanda</th>
										<th>Marca</th>
										<th>Estado</th>
										<th hidden>Concatenado</th>
										<th hidden>Concatenadodetalle</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $banda):?>
											<tr>
												<td hidden><?php echo $banda['idbanda'];?></td>
												<td><?php echo $banda['nombrebanda'];?></td>
												<td><?php echo $banda['marca'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($banda['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td hidden><?php echo $banda['concatenado'];?></td>
												<td hidden><?php echo $banda['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarBanda('<?php echo $banda['idbanda'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $banda['idbanda'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoBanda'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarBanda' tabindex='-1'>
	<div class='modal-dialog modal-lg'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Banda</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row' hidden>
					<label for = idbanda class='col-sm-4'>Idbanda:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idbanda' name='idbanda' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = nombrebanda class='col-sm-4' for='id'>Nombrebanda:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='nombrebanda' name='nombrebanda' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = marca class='col-sm-4' for='id'>Marca:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='marca' name='marca' placeholder='T001' autocomplete = 'off'>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarBanda'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarBanda'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarBanda'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarBanda' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoBanda;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosBanda();
		EnviarInformacionBanda('leer', NuevoBanda, false, pag);
	}
	$('#btnAgregarBanda').click(function(){
		LimpiarModalDatosBanda();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
		$('#btnModalAgregarBanda').toggle(true);
		$('#btnModalEditarBanda').toggle(false);
		$('#btnModalEliminarBanda').toggle(false);
		$('#modalAgregarBanda').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarBanda(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/banda/edit',
			data: {idbanda: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosBanda();
				$('#idbanda').val(temp.idbanda);
				$('#nombrebanda').val(temp.nombrebanda);
				$('#marca').val(temp.marca);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarBanda').toggle(false);
				$('#btnModalEditarBanda').toggle(true);
				$('#btnModalEliminarBanda').toggle(true);
				$('#modalAgregarBanda').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarBanda').click(function(){
		debugger
		if (ValidarCamposVaciosBanda() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosBanda();
			EnviarInformacionBanda('agregar', NuevoBanda, true);
		}
	});
	$('#btnModalEditarBanda').click(function(){
		if (ValidarCamposVaciosBanda() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosBanda();
			EnviarInformacionBanda('modificar', NuevoBanda, true);
		}
	});
	$('#btnModalEliminarBanda').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosBanda();
			EnviarInformacionBanda('eliminar', NuevoBanda, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosBanda();
	});
	$('#btnFiltroBanda').click(function(){
		RecolectarDatosBanda();
		EnviarInformacionBanda('leer', NuevoBanda, false);
	});
	function Paginado(pag) {
		RecolectarDatosBanda();
		EnviarInformacionBanda('leer', NuevoBanda, false, pag);
	}
	function RecolectarDatosBanda(){
		NuevoBanda = {
			idbanda: $('#idbanda').val().toUpperCase(),
			nombrebanda: $('#nombrebanda').val().toUpperCase(),
			marca: $('#marca').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionBanda(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/banda/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoBanda').empty();
				$('#PaginadoBanda').append(resp.pag);
				if (modal) {
					$('#modalAgregarBanda').modal('toggle');
					LimpiarModalDatosBanda();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaBanda(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaBanda(resp.datos)
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
	function LimpiarModalDatosBanda(){
		$('#idbanda').val('0');
		$('#nombrebanda').val('');
		$('#marca').val('');
	}
	function ValidarCamposVaciosBanda(){
		var error = 0;
		var value = $('#idbanda').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idbanda');
			error++;
		}else{
			NoResaltado('idbanda');
		}
		if ($('#nombrebanda').val() == ''){
			Resaltado('nombrebanda');
			error++;
		}else{
			NoResaltado('nombrebanda');
		}
		if ($('#marca').val() == ''){
			Resaltado('marca');
			error++;
		}else{
			NoResaltado('marca');
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
	function CargartablaBanda(objeto){
		$('#TablaBanda tr').not($('#TablaBanda tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idbanda !== null ? value.idbanda : ''}</td>
				<td>${value.nombrebanda !== null ? value.nombrebanda : ''}</td>
				<td>${value.marca !== null ? value.marca : ''}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
				<td hidden>${value.concatenado !== null ? value.concatenado : ''}</td>
				<td hidden>${value.concatenadodetalle !== null ? value.concatenadodetalle : ''}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarBanda('${value.idbanda}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$banda['idbanda']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaBanda tbody').append(fila);
		});
	}
</script>
