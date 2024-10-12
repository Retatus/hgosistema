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
								<button type='button' class='btn btn-info btn-sm' id='btnAgregarServicio'>
									<span class='fa fa-plus'></span> Agregar Servicio
								</button>
								<a href='<?php echo base_url();?>servicio/excel' class='btn btn-success btn-sm'>
									<span class='fa fa-file-excel'></span> Exportar
								</a>
								<a href='<?php echo base_url();?>servicio/pdf' target='_blank' class='btn btn-danger btn-sm'>
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
												<button type='button' class='btn btn-info btn-sm' id='btnFiltroServicio'>
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
						<table id='TablaServicio' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idservicio</th>										
										<th>Idcliente</th>
										<th style="width: 15%;">Cliente</th>
										<th>Observacioningreso</th>
										<th hidden>Idtiposervicio</th>
										<th>Tiposervicio</th>
										<th>Fechaingreso</th>
										<th hidden>Idbanda</th>
										<th>Banda</th>
										<th>Fechasalida</th>
										<th>Observacionsalida</th>
																			
										<th hidden>Idubicacion</th>
										<th>Ubicacion</th>
										
										<th hidden>Idcondicion</th>
										<th>Condicion</th>
										<th hidden>Idneumatico</th>
										<th>Nombre</th>
										<th hidden>Idrencauchadora</th>
										<th>Reencauchadora</th>
										
										<th hidden>Idusuario</th>
										<th hidden>Nombreusuario</th>
										<th hidden>Concatenado</th>
										<th hidden>Concatenadodetalle</th>
										<th>Estado</th>	
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $servicio):?>
											<tr>
												<td hidden><?php echo $servicio['idservicio'];?></td>												
												<td><?php echo $servicio['idcliente'];?></td>
												<td><?php echo $servicio['nombrecliente'];?></td>
												<td><?php echo $servicio['observacioningreso'];?></td>
												<td hidden><?php echo $servicio['idtiposervicio'];?></td>
												<td><?php echo $servicio['nombretiposervicio'];?></td>
												<td><?php echo $servicio['fechaingreso'];?></td>
												<td hidden><?php echo $servicio['idbanda'];?></td>
												<td><?php echo $servicio['nombrebanda'];?></td>
												<td><?php echo $servicio['fechasalida'];?></td>
												<td><?php echo $servicio['observacionsalida'];?></td>																								
												<td hidden><?php echo $servicio['idubicacion'];?></td>
												<td><?php echo $servicio['nombretipoubicacion'];?></td>												
												<td hidden><?php echo $servicio['idcondicion'];?></td>
												<td><?php echo $servicio['nombrecondicion'];?></td>
												<td hidden><?php echo $servicio['idneumatico'];?></td>
												<td><?php echo $servicio['nombreneumatico'];?></td>
												<td hidden><?php echo $servicio['idrencauchadora'];?></td>
												<td><?php echo $servicio['nombrereencauchadora'];?></td>												
												<td hidden><?php echo $servicio['idusuario'];?></td>
												<td hidden><?php echo $servicio['nombreusuario'];?></td>
												<td hidden><?php echo $servicio['concatenado'];?></td>
												<td hidden><?php echo $servicio['concatenadodetalle'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($servicio['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarServicio('<?php echo $servicio['idservicio'].'\',\''.$servicio['idusuario'].'\',\''.$servicio['idcliente'].'\',\''.$servicio['idtiposervicio'].'\',\''.$servicio['idbanda'].'\',\''.$servicio['idneumatico'].'\',\''.$servicio['idubicacion'].'\',\''.$servicio['idrencauchadora'].'\',\''.$servicio['idcondicion'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href="<?php echo base_url();?>reserva/add/<?php echo $servicio['idservicio'].'\',\''.$servicio['idusuario'].'\',\''.$servicio['idcliente'].'\',\''.$servicio['idtiposervicio'].'\',\''.$servicio['idbanda'].'\',\''.$servicio['idneumatico'].'\',\''.$servicio['idubicacion'].'\',\''.$servicio['idrencauchadora'].'\',\''.$servicio['idcondicion'];?>"><i class='fa fa-pencil'></i></a>
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
						<div id='PaginadoServicio'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<!--  SECCION ====== MODAL ====== -->
<div class='modal fade' id='modalAgregarServicio' tabindex='-1'>
	<div class='modal-dialog modal-xl'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title' id='modaldeltalletour'>Detalle Servicio</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
				<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<div class='col-6 form-group row' hidden>
					<label for = idservicio class='col-sm-4'>Idservicio:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='idservicio' name='idservicio' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = fechaingreso class='col-sm-4'>Fechaingreso:</label>
					<div class='col-sm-8'>
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>
									<i class='far fa-calendar-alt'></i>
								</span>
							</div>
							<input type='text' class='form-control form-control-sm' id='fechaingreso' name='fechaingreso' placeholder='dd/mm/yyyy' readonly>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idusuario class='col-sm-4'>Usuario:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idusuario'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($usuarios)):?>
								<?php foreach($usuarios as $usuario):?>
									<option value= '<?php echo $usuario['idusuario'];?>'><?php echo $usuario['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idcliente class='col-sm-4'>Cliente:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idcliente'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($clientes)):?>
								<?php foreach($clientes as $cliente):?>
									<option value= '<?php echo $cliente['idcliente'];?>'><?php echo $cliente['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idtiposervicio class='col-sm-4'>Tiposervicio:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idtiposervicio'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($tiposervicios)):?>
								<?php foreach($tiposervicios as $tiposervicio):?>
									<option value= '<?php echo $tiposervicio['idtiposervicio'];?>'><?php echo $tiposervicio['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idbanda class='col-sm-4'>Banda:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idbanda'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($bandas)):?>
								<?php foreach($bandas as $banda):?>
									<option value= '<?php echo $banda['idbanda'];?>'><?php echo $banda['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idneumatico class='col-sm-4'>Neumatico:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idneumatico'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($neumaticos)):?>
								<?php foreach($neumaticos as $neumatico):?>
									<option value= '<?php echo $neumatico['idneumatico'];?>'><?php echo $neumatico['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idubicacion class='col-sm-4'>Ubicacion:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idubicacion'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($ubicacions)):?>
								<?php foreach($ubicacions as $ubicacion):?>
									<option value= '<?php echo $ubicacion['idubicacion'];?>'><?php echo $ubicacion['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idrencauchadora class='col-sm-4'>Reencauchadora:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idrencauchadora'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($reencauchadoras)):?>
								<?php foreach($reencauchadoras as $reencauchadora):?>
									<option value= '<?php echo $reencauchadora['idrencauchadora'];?>'><?php echo $reencauchadora['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = fechasalida class='col-sm-4'>Fechasalida:</label>
					<div class='col-sm-8'>
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>
									<i class='far fa-calendar-alt'></i>
								</span>
							</div>
							<input type='text' class='form-control form-control-sm' id='fechasalida' name='fechasalida' placeholder='dd/mm/yyyy' readonly>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idcondicion class='col-sm-4'>Condicion:</label>
					<div class = 'col-sm-8'>
						<select class='form-control form-control-sm select2' id='idcondicion'>
							<option value='0'>-- SELECCIONAR1 --</option>
							<?php if (!empty($condicions)):?>
								<?php foreach($condicions as $condicion):?>
									<option value= '<?php echo $condicion['idcondicion'];?>'><?php echo $condicion['concatenado'];?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
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
				<div class='col-12 form-group row'>
					<label for = observacioningreso class='col-sm-4' for='id'>Observacioningreso:</label>
					<div class = 'col-sm-12'>
						<textarea type='text' class='form-control form-control-sm text-uppercase' id='observacioningreso' name='observacioningreso' placeholder='T001' autocomplete = 'off'></textarea>
					</div>
				</div>
				<div class='col-12 form-group row'>
					<label for = observacionsalida class='col-sm-4' for='id'>Observacionsalida:</label>
					<div class = 'col-sm-12'>
						<textarea type='text' class='form-control form-control-sm text-uppercase' id='observacionsalida' name='observacionsalida' placeholder='T001' autocomplete = 'off'></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarServicio'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarServicio'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarServicio'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarServicio' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<!--  SECCION ====== SCRIPT ====== -->
<script>
	var NuevoServicio;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosServicio();
		EnviarInformacionServicio('leer', NuevoServicio, false, pag);
	}
	$('#fechaingreso').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true, 
		onSelect: function(selectedDate) {
			// Cuando se selecciona una fecha de ingreso, actualizar la fecha mínima de salida
			var fechaIngreso = $('#fechaingreso').datepicker('getDate');
			$('#fechasalida').datepicker('option', 'minDate', fechaIngreso);
		}
	});
	
	$('#fechasalida').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true,
		onSelect: function(selectedDate) {
			var fechaIngreso = $('#fechaingreso').datepicker('getDate');
			var fechaSalida = $('#fechasalida').datepicker('getDate');
			
			// Verifica si la fecha de salida es anterior a la de ingreso
			if (fechasalida < fechaIngreso) {
				alert("La fecha de salida no puede ser menor que la fecha de ingreso.");
				$('#fechasalida').val(''); // Limpia el campo si la validación falla
			}
		}
	});
	
	$('#btnAgregarServicio').click(function(){
		LimpiarModalDatosServicio();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#btnModalAgregarServicio').toggle(true);
		$('#btnModalEditarServicio').toggle(false);
		$('#btnModalEliminarServicio').toggle(false);
		$('#modalAgregarServicio').modal();
	});
//   SECCION ====== btn Editar ======
	function btnEditarServicio(Val0, Val1, Val2, Val3, Val4, Val5, Val6, Val7, Val8){
		$.ajax({
			type: 'POST',
			url: base_url + '/servicio/edit',
			data: {idservicio: Val0, idusuario: Val1, idcliente: Val2, idtiposervicio: Val3, idbanda: Val4, idneumatico: Val5, idubicacion: Val6, idrencauchadora: Val7, idcondicion: Val8},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosServicio();
				$('#idservicio').val(temp.idservicio);
				$('#fechaingreso').val(temp.fechaingreso);
				$('#fechaingreso').datepicker('disable');
				$('#idusuario').select2().val(temp.idusuario).select2('destroy').select2();
				$('#observacioningreso').val(temp.observacioningreso);
				$('#idcliente').select2().val(temp.idcliente).select2('destroy').select2();
				$('#idcliente').select2().val(temp.idcliente).prop('disabled', true);
				$('#idtiposervicio').select2().val(temp.idtiposervicio).select2('destroy').select2();
				$('#idbanda').select2().val(temp.idbanda).select2('destroy').select2();
				$('#idneumatico').select2().val(temp.idneumatico).select2('destroy').select2();
				$('#idubicacion').select2().val(temp.idubicacion).select2('destroy').select2();
				$('#idrencauchadora').select2().val(temp.idrencauchadora).select2('destroy').select2();
				$('#fechasalida').val(temp.fechasalida);
				$('#observacionsalida').val(temp.observacionsalida);
				$('#idcondicion').select2().val(temp.idcondicion).select2('destroy').select2();
				$('#estado').val(temp.estado);
				$('#btnModalAgregarServicio').toggle(false);
				$('#btnModalEditarServicio').toggle(true);
				$('#btnModalEliminarServicio').toggle(true);
				$('#modalAgregarServicio').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
	$('#btnModalAgregarServicio').click(function(){
		debugger
		if (ValidarCamposVaciosServicio() != 0) {
			alert('Completar campos obligatorios');
		}else{
			$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
			RecolectarDatosServicio();
			EnviarInformacionServicio('agregar', NuevoServicio, true);
		}
	});
	$('#btnModalEditarServicio').click(function(){
		if (ValidarCamposVaciosServicio() != 0) {
			alert('Completar campos obligatorios');
		}else{
			RecolectarDatosServicio();
			EnviarInformacionServicio('modificar', NuevoServicio, true);
		}
	});
	$('#btnModalEliminarServicio').click(function(){
		var bool=confirm('ESTA SEGURO DE ELIMINAR EL DATO?');
		if(bool){
			RecolectarDatosServicio();
			EnviarInformacionServicio('eliminar', NuevoServicio, true);
		}
	});
	$('#btnModalCerrarHotel').click(function(){
		$('#IdModalGrupoCodigoHotel').prop('hidden', false); 
		LimpiarModalDatosServicio();
	});
	$('#btnFiltroServicio').click(function(){
		RecolectarDatosServicio();
		EnviarInformacionServicio('leer', NuevoServicio, false);
	});
	function Paginado(pag) {
		RecolectarDatosServicio();
		EnviarInformacionServicio('leer', NuevoServicio, false, pag);
	}
	function RecolectarDatosServicio(){
		NuevoServicio = {
			idservicio: $('#idservicio').val().toUpperCase(),
			fechaingreso: $('#fechaingreso').val().toUpperCase(),
			idusuario: $('#idusuario').val().toUpperCase(),
			observacioningreso: $('#observacioningreso').val().toUpperCase(),
			idcliente: $('#idcliente').val().toUpperCase(),
			idtiposervicio: $('#idtiposervicio').val().toUpperCase(),
			idbanda: $('#idbanda').val().toUpperCase(),
			idneumatico: $('#idneumatico').val().toUpperCase(),
			idubicacion: $('#idubicacion').val().toUpperCase(),
			idrencauchadora: $('#idrencauchadora').val().toUpperCase(),
			fechasalida: $('#fechasalida').val().toUpperCase(),
			observacionsalida: $('#observacionsalida').val().toUpperCase(),
			idcondicion: $('#idcondicion').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos: $('#idFTodos').val(),
			texto: $('#idFTexto').val()
		};
	}
	function EnviarInformacionServicio(accion, objEvento, modal, pag=1) { 
		$.ajax({
			type: 'POST',
			url: base_url+'/servicio/opciones?accion='+accion+'&pag='+pag,
			data: objEvento,
			success: function(msg){
				var resp = JSON.parse(msg);
				$('#PaginadoServicio').empty();
				$('#PaginadoServicio').append(resp.pag);
				if (modal) {
					$('#modalAgregarServicio').modal('toggle');
					LimpiarModalDatosServicio();
					if (resp.id == 1) {
						Swal.fire({
							title: resp.mensaje,
							icon: 'success'
							}).then((result) => {
							if (result.value) {
								//window.location.href = base_url + 'mantenimiento/servicios/';
								CargartablaServicio(resp.datos)
							}
						})
					} else {
						Swal.fire({
							title: resp.mensaje,
							icon: 'error'
						})
					}
				}else{
					CargartablaServicio(resp.datos)
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
	function LimpiarModalDatosServicio(){
		$('#idservicio').val('0');
		$('#fechaingreso').val('');
		$('#idusuario').select2().val(0).select2('destroy').select2();
		$('#observacioningreso').val('');
		$('#idcliente').select2().val(0).select2('destroy').select2();
		$('#idtiposervicio').select2().val(0).select2('destroy').select2();
		$('#idbanda').select2().val(0).select2('destroy').select2();
		$('#idneumatico').select2().val(0).select2('destroy').select2();
		$('#idubicacion').select2().val(0).select2('destroy').select2();
		$('#idrencauchadora').select2().val(0).select2('destroy').select2();
		$('#fechasalida').val('');
		$('#observacionsalida').val('');
		$('#idcondicion').select2().val(0).select2('destroy').select2();
	}
	function ValidarCamposVaciosServicio(){
		var error = 0;
		var value = $('#idservicio').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idservicio');
			error++;
		}else{
			NoResaltado('idservicio');
		}
		if ($('#fechaingreso').val() == ''){
			Resaltado('fechaingreso');
			error++;
		}else{
			NoResaltado('fechaingreso');
		}
		if ($('#idusuario').val() == ''){
			Resaltado('idusuario');
			error++;
		}else{
			NoResaltado('idusuario');
		}
		if ($('#observacioningreso').val() == ''){
			Resaltado('observacioningreso');
			error++;
		}else{
			NoResaltado('observacioningreso');
		}
		if ($('#idcliente').val() == ''){
			Resaltado('idcliente');
			error++;
		}else{
			NoResaltado('idcliente');
		}
		var value = $('#idtiposervicio').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idtiposervicio');
			error++;
		}else{
			NoResaltado('idtiposervicio');
		}
		var value = $('#idbanda').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idbanda');
			error++;
		}else{
			NoResaltado('idbanda');
		}
		var value = $('#idneumatico').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idneumatico');
			error++;
		}else{
			NoResaltado('idneumatico');
		}
		var value = $('#idubicacion').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idubicacion');
			error++;
		}else{
			NoResaltado('idubicacion');
		}
		var value = $('#idrencauchadora').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idrencauchadora');
			error++;
		}else{
			NoResaltado('idrencauchadora');
		}
		// if ($('#fechasalida').val() == ''){
		// 	Resaltado('fechasalida');
		// 	error++;
		// }else{
		// 	NoResaltado('fechasalida');
		// }
		// if ($('#observacionsalida').val() == ''){
		// 	Resaltado('observacionsalida');
		// 	error++;
		// }else{
		// 	NoResaltado('observacionsalida');
		// }
		var value = $('#idcondicion').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idcondicion');
			error++;
		}else{
			NoResaltado('idcondicion');
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
	function CargartablaServicio(objeto){
		$('#TablaServicio tr').not($('#TablaServicio tr:first')).remove();
		$.each(objeto, function(i, value) {
				var fila = `<tr>
				<td hidden>${value.idservicio !== null ? value.idservicio : ''}</td>	
				<td>${value.idcliente !== null ? value.idcliente : ''}</td>
				<td>${value.nombrecliente !== null ? value.nombrecliente : ''}</td>			
				<td>${value.observacioningreso !== null ? value.observacioningreso : ''}</td>
				<td hidden>${value.idtiposervicio !== null ? value.idtiposervicio : ''}</td>
				<td>${value.nombretiposervicio !== null ? value.nombretiposervicio : ''}</td>
				<td>${value.fechaingreso !== null ? value.fechaingreso : ''}</td>
				<td hidden>${value.idbanda !== null ? value.idbanda : ''}</td>
				<td>${value.nombrebanda !== null ? value.nombrebanda : ''}</td>			
				<td>${value.fechasalida !== null ? value.fechasalida : ''}</td>
				<td>${value.observacionsalida !== null ? value.observacionsalida : ''}</td>				
				<td hidden>${value.idubicacion !== null ? value.idubicacion : ''}</td>
				<td>${value.nombretipoubicacion !== null ? value.nombretipoubicacion : ''}</td>								
				<td hidden>${value.idcondicion !== null ? value.idcondicion : ''}</td>
				<td>${value.nombrecondicion !== null ? value.nombrecondicion : ''}</td>
				<td hidden>${value.idneumatico !== null ? value.idneumatico : ''}</td>
				<td>${value.nombreneumatico !== null ? value.nombreneumatico : ''}</td>
				<td hidden>${value.idrencauchadora !== null ? value.idrencauchadora : ''}</td>
				<td>${value.nombrereencauchadora !== null ? value.nombrereencauchadora : ''}</td>				
				<td hidden>${value.idusuario !== null ? value.idusuario : ''}</td>
				<td hidden>${value.nombreusuario !== null ? value.nombreusuario : ''}</td>
				<td hidden>${value.concatenado !== null ? value.concatenado : ''}</td>
				<td hidden>${value.concatenadodetalle !== null ? value.concatenadodetalle : ''}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>				
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarServicio('${value.idservicio}', '${value.idusuario}', '${value.idcliente}', '${value.idtiposervicio}', '${value.idbanda}', '${value.idneumatico}', '${value.idubicacion}', '${value.idrencauchadora}', '${value.idcondicion}')" class='btn btn-info btn-xs'>
							<span class='fa fa-search fa-xs'></span>
						</button>
					</div>
						<div style='margin: auto;'>
							<a class='btn btn-success btn-xs' href='<?php echo base_url();?>/reserva/add/$servicio['idservicio'].'\',\''.$servicio['idusuario'].'\',\''.$servicio['idcliente'].'\',\''.$servicio['idtiposervicio'].'\',\''.$servicio['idbanda'].'\',\''.$servicio['idneumatico'].'\',\''.$servicio['idubicacion'].'\',\''.$servicio['idrencauchadora'].'\',\''.$servicio['idcondicion']'><i class='fa fa-pencil'></i></a>
					</div>
				</div>
				</td>
				</tr>`
			$('#TablaServicio tbody').append(fila);
		});
	}
</script>
