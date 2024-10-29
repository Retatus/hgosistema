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
									<span class='fa fa-plus'></span> Agregar
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
											<select id='idFTodos2' class='form-control form-control-sm'>
												<option value=''>TODOS</option>
												<option value='1'>CANCELADO</option>
												<option value='0' selected>PENDIENTE</option>
											</select>
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
						<div class='demo-content'>
							<table id='TablaServicio' class='table table-sm table-bordered table-striped'>
								<thead>
									<tr>
										<th hidden>Idservicio</th>
										<th class = 'tableheader blue'>RUC</th>
										<th class = 'tableheader blue'>RAZON SOCIAL</th>
										<th class = 'tableheader blue'>FECHA REPCION</th>
										<th hidden>Idbanda</th>
										<th class = 'tableheader blue'>DISEÑO BANDA</th>
										<th class = 'tableheader blue'>PLACA</th>
										<th class = 'tableheader blue'>OBSERVACION INGRESO</th>
										<th hidden>Idtiposervicio</th>
										<th class = 'tableheader blue'>TIPO SERVICIO</th>
										
										<th hidden>Idmedida</th>
										<th class = 'tableheader blue'>MEDIDA</th>
										<th hidden>Idmarca</th>
										<th class = 'tableheader blue'>MARCA</th>
										<th class = 'tableheader green'>CODIGO</th>
										<th hidden>Idubicacion</th>
										<th class = 'tableheader green'>UBICACION</th>
										<th hidden>Idreencauchadora</th>
										<th class = 'tableheader green'>REEN CAUCHADORA</th>
										<th class = 'tableheader green'>FECHA TIENDA</th>
										<th hidden>Idcondicion</th>
										<th class = 'tableheader blue'>CONDICION</th>
										<th class = 'tableheader orange'>FECHA ENTREGA</th>
										<th class = 'tableheader orange'>OBSERVACION SALIDA</th>
										<th hidden>Usuario</th>
										<th class = 'tableheader blue'>FORMA</th>
										<th class = 'tableheader blue'>ESTADO</th>
										<th hidden>Concatenado</th>
										<th hidden>Concatenadodetalle</th>
										<th class = 'tableheader blue'>ACCIONES</th>
									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $servicio):?>
											<tr>
												<td hidden><?php echo $servicio['idservicio'];?></td>												
												<td><?php echo $servicio['idcliente'];?></td>
												<td><?php echo $servicio['nombrecliente'];?></td>
												<td><?php echo $servicio['fecharecepcion'];?></td>
												<td hidden><?php echo $servicio['idbanda'];?></td>
												<td><?php echo $servicio['nombrebanda'];?></td>
												<td><?php echo $servicio['placa'];?></td>
												<td><?php echo $servicio['observacioningreso'];?></td>
												<td hidden><?php echo $servicio['idtiposervicio'];?></td>
												<td><?php echo $servicio['nombretiposervicio'];?></td>
												<td hidden><?php echo $servicio['idmedida'];?></td>
												<td><?php echo $servicio['nombremedida'];?></td>
												<td hidden><?php echo $servicio['idmarca'];?></td>
												<td><?php echo $servicio['nombremarca'];?></td>																								
												<td><?php echo $servicio['codigo'];?></td>
												<td hidden><?php echo $servicio['idubicacion'];?></td>
												<td><?php echo $servicio['nombretipoubicacion'];?></td>
												<td hidden><?php echo $servicio['idreencauchadora'];?></td>
												<td><?php echo $servicio['nombrereencauchadora'];?></td>
												<td><?php echo $servicio['fechatienda'];?></td>
												<td hidden><?php echo $servicio['idcondicion'];?></td>
												<td><?php echo $servicio['nombrecondicion'];?></td>
												<td><?php echo $servicio['fechaentrega'];?></td>
												<td><?php echo $servicio['observacionsalida'];?></td>
												<td hidden><?php echo $servicio['usuario'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($servicio['formaestado']== 1) ? 'CANCELADO' : 'PENDIENTE';?></td>
												<td class = 'hidden-xs'><?php echo $est = ($servicio['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>												
												<td hidden><?php echo $servicio['concatenado'];?></td>
												<td hidden><?php echo $servicio['concatenadodetalle'];?></td>
												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarServicio('<?php echo $servicio['idservicio'].'\',\''.$servicio['idcliente'].'\',\''.$servicio['idbanda'].'\',\''.$servicio['idtiposervicio'].'\',\''.$servicio['idmedida'].'\',\''.$servicio['idmarca'].'\',\''.$servicio['idubicacion'].'\',\''.$servicio['idreencauchadora'].'\',\''.$servicio['idcondicion'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-pencil fa-xs'></span>
															</button>
														</div>
														<?php if(intval(session()->get('user_rol')) === 1):?>
															<div style='margin: auto;'>
																<button type='button' onclick="btnVerAuditoria('<?php echo $servicio['idservicio'];?>')" class='btn btn-success btn-xs'>
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
					<label for = idcliente class='col-sm-4'>Cliente:</label>
					<div class = 'col-sm-8'>
					<div class='input-group input-group-sm'>
							<input type='search' id='searchidcliente' placeholder='Ingrese el nombre del idcliente' class='form-control form-control-sm search'>
							<input type='text' id='idcliente' name='idcliente' class='form-control form-control-sm' readonly>
							<span class='input-group-append'>
								<button type='button' class='btn btn-info btn-flat' id='btnAddCliente'>+</button>
							</span>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = fecharecepcion class='col-sm-4'>Fecharecepcion:</label>
					<div class='col-sm-8'>
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>
									<i class='far fa-calendar-alt'></i>
								</span>
							</div>
							<input type='text' class='form-control form-control-sm' id='fecharecepcion' name='fecharecepcion' placeholder='dd/mm/yyyy' readonly>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idbanda class='col-sm-4'>Banda:</label>
					<div class = 'col-sm-8'>
					<div class="input-group input-group-sm">
							<select class='form-control form-control-sm select2' id='idbanda'>
								<option value='0'>-- SELECCIONAR1 --</option>
								<?php if (!empty($bandas)):?>
									<?php foreach($bandas as $banda):?>
										<option value= '<?php echo $banda['idbanda'];?>'><?php echo $banda['concatenado'];?></option>
									<?php endforeach;?>
								<?php endif;?>
							</select>
							<span class="input-group-append">
								<button type="button" class="btn btn-info btn-flat" id='btnAddBanda'>+</button>
							</span>
						</div>		
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = placa class='col-sm-4' for='id'>Placa:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='placa' name='placa' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idtiposervicio class='col-sm-4'>Tiposervicio:</label>
					<div class = 'col-sm-8'>
						<div class="input-group input-group-sm">
							<select class='form-control form-control-sm select2' id='idtiposervicio'>
								<option value='0'>-- SELECCIONAR1 --</option>
								<?php if (!empty($tiposervicios)):?>
									<?php foreach($tiposervicios as $tiposervicio):?>
										<option value= '<?php echo $tiposervicio['idtiposervicio'];?>'><?php echo $tiposervicio['concatenado'];?></option>
									<?php endforeach;?>
								<?php endif;?>
							</select>
							<span class="input-group-append">
								<button type="button" class="btn btn-info btn-flat" id='btnAddTiposervicio'>+</button>
							</span>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idmedida class='col-sm-4'>Medida:</label>
					<div class = 'col-sm-8'>
						<div class="input-group input-group-sm">
							<select class='form-control form-control-sm select2' id='idmedida'>
								<option value='0'>-- SELECCIONAR1 --</option>
								<?php if (!empty($medidas)):?>
									<?php foreach($medidas as $medida):?>
										<option value= '<?php echo $medida['idmedida'];?>'><?php echo $medida['concatenado'];?></option>
									<?php endforeach;?>
								<?php endif;?>
							</select>
							<span class="input-group-append">
								<button type="button" class="btn btn-info btn-flat" id='btnAddMedida'>+</button>
							</span>
						</div>							
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idmarca class='col-sm-4'>Marca:</label>
					<div class = 'col-sm-8'>
						<div class="input-group input-group-sm">
							<select class='form-control form-control-sm select2' id='idmarca'>
								<option value='0'>-- SELECCIONAR1 --</option>
								<?php if (!empty($marcas)):?>
									<?php foreach($marcas as $marca):?>
										<option value= '<?php echo $marca['idmarca'];?>'><?php echo $marca['concatenado'];?></option>
									<?php endforeach;?>
								<?php endif;?>
							</select>
							<span class="input-group-append">
								<button type="button" class="btn btn-info btn-flat" id='btnAddMarca'>+</button>
							</span>
						</div>							
					</div>																																																																																																																																																																																																																																																																																																																																																								
				</div>
				<div class='col-6 form-group row'>
					<label for = codigo class='col-sm-4' for='id'>Codigo:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='codigo' name='codigo' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idubicacion class='col-sm-4'>Ubicacion:</label>
					<div class = 'col-sm-8'>
						<div class="input-group input-group-sm">
							<select class='form-control form-control-sm select2' id='idubicacion'>
								<option value='0'>-- SELECCIONAR1 --</option>
								<?php if (!empty($ubicacions)):?>
									<?php foreach($ubicacions as $ubicacion):?>
										<option value= '<?php echo $ubicacion['idubicacion'];?>'><?php echo $ubicacion['concatenado'];?></option>
									<?php endforeach;?>
								<?php endif;?>
							</select>
							<span class="input-group-append">
								<button type="button" class="btn btn-info btn-flat" id='btnAddUbicacion'>+</button>
							</span>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idreencauchadora class='col-sm-4'>Reencauchadora:</label>
					<div class = 'col-sm-8'>
						<div class="input-group input-group-sm">
							<select class='form-control form-control-sm select2' id='idreencauchadora'>
								<option value='0'>-- SELECCIONAR1 --</option>
								<?php if (!empty($reencauchadoras)):?>
									<?php foreach($reencauchadoras as $reencauchadora):?>
										<option value= '<?php echo $reencauchadora['idreencauchadora'];?>'><?php echo $reencauchadora['concatenado'];?></option>
									<?php endforeach;?>
								<?php endif;?>
							</select>
							<span class="input-group-append">
								<button type="button" class="btn btn-info btn-flat" id='btnAddReencauchadora'>+</button>
							</span>
						</div>						
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = fechatienda class='col-sm-4'>Fechatienda:</label>
					<div class='col-sm-8'>
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>
									<i class='far fa-calendar-alt'></i>
								</span>
							</div>
							<input type='text' class='form-control form-control-sm' id='fechatienda' name='fechatienda' placeholder='dd/mm/yyyy' readonly>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = idcondicion class='col-sm-4'>Condicion:</label>
					<div class='col-sm-8'>
						<div class="input-group input-group-sm">
							<select class='form-control form-control-sm select2'  id='idcondicion'>
								<option value='0'>-- SELECCIONAR1 --</option>
								<?php if (!empty($condicions)): ?>
									<?php foreach($condicions as $condicion): ?>
										<option value='<?php echo $condicion['idcondicion']; ?>'><?php echo $condicion['concatenado']; ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
							<span class="input-group-append">
								<button type="button" class="btn btn-info btn-flat" id='btnAddCondicion'>+</button>
							</span>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = fechaentrega class='col-sm-4'>Fechaentrega:</label>
					<div class='col-sm-8'>
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>
									<i class='far fa-calendar-alt'></i>
								</span>
							</div>
							<input type='text' class='form-control form-control-sm' id='fechaentrega' name='fechaentrega' placeholder='dd/mm/yyyy' readonly>
						</div>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = usuario class='col-sm-4' for='id'>Usuario:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='usuario' name='usuario' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = formaestado class='col-sm-4' for='rol'>Forma:</label>
					<div class='col-sm-8'>
						<select class='form-control form-control-sm' id='formaestado' name='formaestado'>
							<option value = '1' selected >CANCELADO</option>
							<option value = '0' >PENDIENTE</option>
						</select>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label for = docrefrencia class='col-sm-4' for='id'>Docrefrencia:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase' id='docrefrencia' name='docrefrencia' placeholder='T001' autocomplete = 'off'>
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
<style>
	.card-body { 
		overflow-x: auto; /* Activa el scroll horizontal */
		white-space: nowrap; Evita que el contenido se envuelva a la siguiente línea */
		max-width: 100%; /* Ajusta el ancho máximo según sea necesario */
	} 
</style>
<!--  SECCION ====== SCRIPT ====== -->
<script>

	$('.search').on('click', function() {
		$('#idcliente').val('');
	});
	
	var NuevoServicio;
	var base_url= '<?php echo base_url();?>';
	function load(pag){
		RecolectarDatosServicio();
		EnviarInformacionServicio('leer', NuevoServicio, false, pag);
	}
	$('#fecharecepcion').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true,
		onSelect: function(selectedDate) {
			// Cuando se selecciona una fecha de ingreso, actualizar la fecha mínima de salida
			var fecharecepcion = $('#fecharecepcion').datepicker('getDate');
			$('#fechatienda').datepicker('option', 'minDate', fecharecepcion);	
			$('#fechaentrega').datepicker('option', 'minDate', fecharecepcion);				
		}
	});
	
	$('#fechatienda').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true,
		onSelect: function(selectedDate) {
			var fecharecepcion = $('#fecharecepcion').datepicker('getDate');
			var fechatienda = $('#fechatienda').datepicker('getDate');
			$('#fechaentrega').datepicker('option', 'minDate', fechatienda);
			// Verifica si la fecha de salida es anterior a la de ingreso
			if (fechatienda < fecharecepcion) {
				alert("La fecha de salida no puede ser menor que la fecha de ingreso.");
				$('#fechatienda').val(''); // Limpia el campo si la validación falla
			}
		}
	});
	
	$('#fechaentrega').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true,
		onSelect: function(selectedDate) {
			var fecharecepcion = $('#fecharecepcion').datepicker('getDate');
			var fechaentrega = $('#fechaentrega').datepicker('getDate');
			
			// Verifica si la fecha de salida es anterior a la de ingreso
			if (fechaentrega < fecharecepcion) {
				alert("La fecha de salida no puede ser menor que la fecha de ingreso.");
				$('#fechaentrega').val(''); // Limpia el campo si la validación falla
			}
		}
	});
	
	$('#btnAgregarServicio').click(function(){
		LimpiarModalDatosServicio();
		$('#categoria').val(1);
		$('#id').prop('readonly', false);  
		$('#usuario').prop('disabled', false); 
		$('#IdModalGrupoCodigoHotel').prop('hidden', false);
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
			data: {idservicio: Val0, idcliente: Val1, idbanda: Val2, idtiposervicio: Val3, idmedida: Val4, idmarca: Val5, idubicacion: Val6, idreencauchadora: Val7, idcondicion: Val8},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
				LimpiarModalDatosServicio();
				$('#idservicio').val(temp.idservicio);
				$('#idcliente').val(temp.idcliente);
				//$('#idcliente').select2().val(temp.idcliente).select2('destroy').select2();
				$('#fecharecepcion').val(temp.fecharecepcion);
				$('#idbanda').select2().val(temp.idbanda).select2('destroy').select2();
				$('#placa').val(temp.placa);
				$('#observacioningreso').val(temp.observacioningreso);
				$('#idtiposervicio').select2().val(temp.idtiposervicio).select2('destroy').select2();
				$('#idmedida').select2().val(temp.idmedida).select2('destroy').select2();
				$('#idmarca').select2().val(temp.idmarca).select2('destroy').select2();
				$('#codigo').val(temp.codigo);
				$('#idubicacion').select2().val(temp.idubicacion).select2('destroy').select2();
				$('#idreencauchadora').select2().val(temp.idreencauchadora).select2('destroy').select2();
				$('#fechatienda').val(temp.fechatienda);
				$('#idcondicion').select2().val(temp.idcondicion).select2('destroy').select2();
				$('#fechaentrega').val(temp.fechaentrega);
				$('#observacionsalida').val(temp.observacionsalida);
				$('#usuario').val(temp.usuario);
				$('#usuario').prop('disabled', true);
				$('#formaestado').val(temp.formaestado);
				$('#docrefrencia').val(temp.docrefrencia);
				$('#estado').val(temp.estado);
				$('#btnModalAgregarServicio').toggle(false);
				$('#btnModalEditarServicio').toggle(true);
				$('#btnModalEliminarServicio').toggle(true);
				$('#modalAgregarServicio').modal('toggle');

				$.post(base_url+'/cliente/edit', { idcliente: temp.idcliente })
				.done(function(data) {
					var respt = JSON.parse(data);
					$('#searchidcliente').val(respt.nombrecliente);
				})
				.fail(function() {
					alert('Ocurrió un error al guardar los datos.');
				});
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
			idcliente: $('#idcliente').val().toUpperCase(),
			idclientetext: $('#searchidcliente').text().toUpperCase(),
			fecharecepcion: $('#fecharecepcion').val().toUpperCase(),
			idbanda: $('#idbanda').val().toUpperCase(),
			idbandatext: $('#idbanda option:selected').text().toUpperCase(),
			placa: $('#placa').val().toUpperCase(),
			observacioningreso: $('#observacioningreso').val().toUpperCase(),
			idtiposervicio: $('#idtiposervicio').val().toUpperCase(),
			idtiposerviciotext: $('#idtiposervicio option:selected').text().toUpperCase(),
			idmedida: $('#idmedida').val().toUpperCase(),
			idmedidatext: $('#idmedida option:selected').text().toUpperCase(),
			idmarca: $('#idmarca').val().toUpperCase(),
			idmarcatext: $('#idmarca option:selected').text().toUpperCase(),
			codigo: $('#codigo').val().toUpperCase(),
			idubicacion: $('#idubicacion').val().toUpperCase(),
			idubicaciontext: $('#idubicacion option:selected').text().toUpperCase(),
			idreencauchadora: $('#idreencauchadora').val().toUpperCase(),
			idreencauchadoratext: $('#idreencauchadora option:selected').text().toUpperCase(),
			fechatienda: $('#fechatienda').val().toUpperCase(),
			idcondicion: $('#idcondicion').val().toUpperCase(),
			idcondiciontext: $('#idcondicion option:selected').text().toUpperCase(),
			fechaentrega: $('#fechaentrega').val().toUpperCase(),
			observacionsalida: $('#observacionsalida').val().toUpperCase(),
			usuario: $('a.d-block').text(),
			formaestado: $('#formaestado').val().toUpperCase(),
			docrefrencia: $('#docrefrencia').val().toUpperCase(),
			estado: $('#estado').val().toUpperCase(),
			todos2: $('#idFTodos2').val(),
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
	$('#searchidcliente').autocomplete({
		source: function(request, response) {
			$.ajax({
			url: base_url+'/cliente/autocompleteclientes',
				type: 'GET',
				data: {
					term: request.term
				},
				dataType: 'json',
				success: function(data) {
					response(data);
				}
			});
		},
		minLength: 2, // Número mínimo de caracteres para activar el autocomplete
		select: function(event, ui) {
			$('#idcliente').val(ui.item.id); // Guardar el ID del cliente seleccionado
			$('#searchidcliente').val(ui.item.value); // Mostrar el nombre seleccionado en el input
			return false; // Evitar que jQuery UI Autocomplete coloque el valor automáticamente
		}
	});

	

	function LimpiarModalDatosServicio(){
		$('#idservicio').val('0');
		$('#searchidcliente').val('');
		$('#idcliente').val('');
		$('#fecharecepcion').val('');
		$('#idbanda').select2().val(0).select2('destroy').select2();
		$('#placa').val('');
		$('#observacioningreso').val('');
		$('#idtiposervicio').select2().val(1).select2('destroy').select2();
		$('#idmedida').select2().val(0).select2('destroy').select2();
		$('#idmarca').select2().val(0).select2('destroy').select2();
		$('#codigo').val('');
		$('#idubicacion').select2().val(0).select2('destroy').select2();
		$('#idreencauchadora').select2().val(0).select2('destroy').select2();
		$('#fechatienda').val('');
		$('#idcondicion').select2().val(0).select2('destroy').select2();
		$('#fechaentrega').val('');
		$('#observacionsalida').val('');
		$('#usuario').val('');
		//$('#formaestado').val('');
		$('#docrefrencia').val('');
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
		if ($('#idcliente').val() == ''){
			Resaltado('idcliente');
			error++;
		}else{
			NoResaltado('idcliente');
		}
		if ($('#fecharecepcion').val() == ''){
			Resaltado('fecharecepcion');
			error++;
		}else{
			NoResaltado('fecharecepcion');
		}
		var value = $('#idbanda').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idbanda');
			error++;
		}else{
			NoResaltado('idbanda');
		}
		// if ($('#placa').val() == ''){
		// 	Resaltado('placa');
		// 	error++;
		// }else{
		// 	NoResaltado('placa');
		// }
		// if ($('#observacioningreso').val() == ''){
		// 	Resaltado('observacioningreso');
		// 	error++;
		// }else{
		// 	NoResaltado('observacioningreso');
		// }
		var value = $('#idtiposervicio').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idtiposervicio');
			error++;
		}else{
			NoResaltado('idtiposervicio');
		}
		// if ($('#numero').val() == ''){
		// 	Resaltado('numero');
		// 	error++;
		// }else{
		// 	NoResaltado('numero');
		// }
		var value = $('#idmarca').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idmarca');
			error++;
		}else{
			NoResaltado('idmarca');
		}
		// if ($('#codigo').val() == ''){
		// 	Resaltado('codigo');
		// 	error++;
		// }else{
		// 	NoResaltado('codigo');
		// }
		var value = $('#idubicacion').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idubicacion');
			error++;
		}else{
			NoResaltado('idubicacion');
		}
		var value = $('#idreencauchadora').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idreencauchadora');
			error++;
		}else{
			NoResaltado('idreencauchadora');
		}
		// if ($('#fechatienda').val() == ''){
		// 	Resaltado('fechatienda');
		// 	error++;
		// }else{
		// 	NoResaltado('fechatienda');
		// }
		var value = $('#idcondicion').val();
		if (!/^\d*$/.test(value)){
			Resaltado('idcondicion');
			error++;
		}else{
			NoResaltado('idcondicion');
		}
		// if ($('#fechaentrega').val() == ''){
		// 	Resaltado('fechaentrega');
		// 	error++;
		// }else{
		// 	NoResaltado('fechaentrega');
		// }
		// if ($('#observacionsalida').val() == ''){
		// 	Resaltado('observacionsalida');
		// 	error++;
		// }else{
		// 	NoResaltado('observacionsalida');
		// }
		// if ($('#usuario').val() == ''){
		// 	Resaltado('usuario');
		// 	error++;
		// }else{
		// 	NoResaltado('usuario');
		// }
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
				<td>${value.fecharecepcion !== null ? value.fecharecepcion : ''}</td>
				<td hidden>${value.idbanda !== null ? value.idbanda : ''}</td>
				<td>${value.nombrebanda !== null ? value.nombrebanda : ''}</td>
				<td>${value.placa !== null ? value.placa : ''}</td>
				<td>${value.observacioningreso !== null ? value.observacioningreso : ''}</td>
				<td hidden>${value.idtiposervicio !== null ? value.idtiposervicio : ''}</td>
				<td>${value.nombretiposervicio !== null ? value.nombretiposervicio : ''}</td>				
				<td hidden>${value.idmedida !== null ? value.idmedida : ''}</td>
				<td>${value.nombremedida !== null ? value.nombremedida : ''}</td>
				<td hidden>${value.idmarca !== null ? value.idmarca : ''}</td>
				<td>${value.nombremarca !== null ? value.nombremarca : ''}</td>
				<td>${value.codigo !== null ? value.codigo : ''}</td>
				<td hidden>${value.idubicacion !== null ? value.idubicacion : ''}</td>
				<td>${value.nombretipoubicacion !== null ? value.nombretipoubicacion : ''}</td>
				<td hidden>${value.idreencauchadora !== null ? value.idreencauchadora : ''}</td>
				<td>${value.nombrereencauchadora !== null ? value.nombrereencauchadora : ''}</td>
				<td>${value.fechatienda !== null ? value.fechatienda : ''}</td>
				<td hidden>${value.idcondicion !== null ? value.idcondicion : ''}</td>
				<td>${value.nombrecondicion !== null ? value.nombrecondicion : ''}</td>
				<td>${value.fechaentrega !== null ? value.fechaentrega : ''}</td>
				<td>${value.observacionsalida !== null ? value.observacionsalida : ''}</td>
				<td hidden>${value.usuario !== null ? value.usuario : ''}</td>
				<td class = 'hidden-xs'>${value.formaestado == '1' ? 'CANCELADO' : 'PENDIENTE'}</td>
				<td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>				
				<td hidden>${value.concatenado !== null ? value.concatenado : ''}</td>
				<td hidden>${value.concatenadodetalle !== null ? value.concatenadodetalle : ''}</td>
				<td>
				<div class='row'>
					<div style='margin: auto;'>
						<button type='button' onclick="btnEditarServicio('${value.idservicio}', '${value.idcliente}', '${value.idbanda}', '${value.idtiposervicio}', '${value.idmedida}', '${value.idmarca}', '${value.idubicacion}', '${value.idreencauchadora}', '${value.idcondicion}')" class='btn btn-info btn-xs'>
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
			$('#TablaServicio tbody').append(fila);
		});
	}
</script>
