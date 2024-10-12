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
										<th hidden>Id</th>
										<th >Fechaingreso</th>
										<th >Idcliente</th>
										<th hidden>Usuario</th>
										<th hidden>Idusuario</th>
										<th >Observacioningreso</th>
										<th>Tiposervicio</th>
										<th hidden>Idtipo</th>
										<th>Banda</th>
										<th hidden>Idbanda</th>
										<th hidden>Idneumatico</th>
										<th>Ubicacion</th>
										<th hidden>Idubicacion</th>
										<th>Reencauchadora</th>
										<th hidden>Idrencauchadora</th>
										<th >Fecchasalida</th>
										<th >Observacionsalida</th>
										<th>Condicion</th>
										<th hidden>Idcondicion</th>
										<th >Estado</th>
										<th>Acciones</th>

									</tr>
								</thead>
								<tbody>
									<?php if(!empty($datos)):?>
										<?php foreach($datos as $servicio):?>
											<tr>
												<td hidden><?php echo $servicio['idservicio'];?></td>
												<td ><?php echo $servicio['fechaingreso'];?></td>
												<td ><?php echo $servicio['idcliente'];?></td>
												<td hidden><?php echo $servicio['nombreusuario'];?></td>
												<td hidden><?php echo $servicio['idusuario'];?></td>
												<td ><?php echo $servicio['observacioningreso'];?></td>												
												<td><?php echo $servicio['nombretiposervicio'];?></td>
												<td hidden><?php echo $servicio['idtiposervicio'];?></td>
												<td><?php echo $servicio['nombrebanda'];?></td>
												<td hidden><?php echo $servicio['idbanda'];?></td>
												<td hidden><?php echo $servicio['idneumatico'];?></td>
												<td><?php echo $servicio['nombretipoubicacion'];?></td>
												<td hidden><?php echo $servicio['idubicacion'];?></td>
												<td><?php echo $servicio['nombrereencauchadora'];?></td>
												<td hidden><?php echo $servicio['idrencauchadora'];?></td>
												<td ><?php echo $servicio['fecchasalida'];?></td>
												<td ><?php echo $servicio['observacionsalida'];?></td>
												<td><?php echo $servicio['nombrecondicion'];?></td>
												<td hidden><?php echo $servicio['idcondicion'];?></td>
												<td class = 'hidden-xs'><?php echo $est = ($servicio['estado']== 1) ? 'ACTIVO' : 'DESACTIVO';?></td>

												<td>
													<div class='row'>
														<div style='margin: auto;'>
															<button type='button' onclick="btnEditarServicio('<?php echo $servicio['idservicio'].'\',\''. $servicio['idcliente'].'\',\''. $servicio['idubicacion'].'\',\''. $servicio['idbanda'].'\',\''. $servicio['idcondicion'].'\',\''. $servicio['idneumatico'].'\',\''. $servicio['idrencauchadora'].'\',\''. $servicio['idtiposervicio'].'\',\''. $servicio['idusuario'];?>')" class='btn btn-info btn-xs'>
																<span class='fa fa-search fa-xs'></span>
															</button>
														</div>
														<div style='margin: auto;'>
															<a class='btn btn-success btn-xs' href='<?php echo base_url();?>reserva/add/<?php echo $servicio['idservicio'].'\',\''. $servicio['idcliente'].'\',\''. $servicio['idubicacion'].'\',\''. $servicio['idbanda'].'\',\''. $servicio['idcondicion'].'\',\''. $servicio['idneumatico'].'\',\''. $servicio['idrencauchadora'].'\',\''. $servicio['idtiposervicio'].'\',\''. $servicio['idusuario'];?>'><i class='fa fa-pencil'></i></a>
														</div>
													</div>
												</td>
											</tr>
										<?php endforeach;?>
									<?php endif;?>
								</tbody>
							</table>
						</div>
						<div id='PaginadoServicio'>
							<?php echo $pag;?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
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
				<div class='col-6 form-group row'hidden>
					<label class='col-sm-4' for='id'>id:</label>
					<div class = 'col-sm-8'>
						<input type='text' class='form-control form-control-sm text-uppercase    123' id='idservicio' name='idservicio' placeholder='T001' autocomplete = 'off'>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>fechaingreso:</label>
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
					<label class='col-sm-4'>Cliente:</label>
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
					<label class='col-sm-4'>Ubicacion:</label>
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
					<label class='col-sm-4'>Banda:</label>
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
					<label class='col-sm-4'>Condicion:</label>
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
					<label class='col-sm-4'>Neumatico:</label>
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
					<label class='col-sm-4'>Reencauchadora:</label>
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
					<label class='col-sm-4'>Tiposervicio:</label>
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
					<label class='col-sm-4'>Usuario:</label>
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
				<div class='col-12 form-group row'>
					<label class='col-sm-2' for='id'>observacioningreso:</label>
					<div class = 'col-sm-10'>
						<textarea type='text' class='form-control form-control-sm text-uppercase    123' id='observacioningreso' name='observacioningreso' placeholder='T001' autocomplete = 'off'></textarea>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4'>fecchasalida:</label>
					<div class='col-sm-8'>
						<div class='input-group'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>
									<i class='far fa-calendar-alt'></i>
								</span>
							</div>
							<input type='text' class='form-control form-control-sm' id='fecchasalida' name='fecchasalida' placeholder='dd/mm/yyyy' readonly>
						</div>
					</div>
				</div>
				<div class='col-12 form-group row'>
					<label class='col-sm-2' for='id'>observacionsalida:</label>
					<div class = 'col-sm-10'>
						<textarea type='text' class='form-control form-control-sm text-uppercase    123' id='observacionsalida' name='observacionsalida' placeholder='T001' autocomplete = 'off'></textarea>
					</div>
				</div>
				<div class='col-6 form-group row'>
					<label class='col-sm-4' for='rol'>estado:</label>
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
			<button type='button' class='btn btn-success btn-sm' id='btnModalAgregarServicio'>Agregar</button>
			<button type='button' class='btn btn-warning btn-sm' id='btnModalEditarServicio'>Modificar</button>
			<button type='button' class='btn btn-danger btn-sm' id='btnModalEliminarServicio'>Eliminar</button>
			<button type='button' class='btn btn-primary btn-sm' id='btnModalCerrarServicio' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_tcliente' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-xl'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Cliente</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Cliente:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaCliente'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaCliente'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_tubicacion' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-xl'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Ubicacion</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Ubicacion:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaUbicacion'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaUbicacion'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_tbanda' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-xl'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Banda</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Banda:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaBanda'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaBanda'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_tcondicion' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-xl'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Condicion</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Condicion:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaCondicion'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaCondicion'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_tneumatico' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-xl'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Neumatico</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Neumatico:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaNeumatico'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaNeumatico'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_treencauchadora' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-xl'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Reencauchadora</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Reencauchadora:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaReencauchadora'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaReencauchadora'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_ttiposervicio' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-xl'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Tiposervicio</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Tiposervicio:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaTiposervicio'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaTiposervicio'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>
<div class='modal fade show' id='modal_agregar_tusuario' aria-modal='true' style='padding-right: 17px;z-index: 2500;'>
	<div class='modal-dialog modal-xl'>
		<div class='modal-content'>
		<div class='modal-header'>
			<h4 class='modal-title'>Agregar Usuario</h4>
			<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
			<span aria-hidden='true'>×</span>
			</button>
		</div>
		<div class='modal-body'>
			<div class='form-group row'>
				<label class='col-sm-3'>Usuario:</label>
				<div class = 'col-sm-9'>
					<input type='text' class='form-control form-control-sm' id='IdNuevaUsuario'>
				</div>
			</div>
		</div>
		<div class='modal-footer'>
			<button type='button' class='btn btn-success btn-sm' id='IdBtnNuevaUsuario'>Agregar</button>
			<button type='button' class='btn btn-primary btn-sm' data-dismiss='modal'>Cerrar</button>
		</div>
		</div>
	</div>
</div>

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
			$('#fecchasalida').datepicker('option', 'minDate', fechaIngreso);
		}
	});
	
	$('#fecchasalida').datepicker({
		language: 'es',
		todayBtn: 'linked',
		clearBtn: true,
		format: 'mm/dd/yyyy',
		multidate: false,
		todayHighlight: true,
		onSelect: function(selectedDate) {
			var fechaIngreso = $('#fechaingreso').datepicker('getDate');
			var fechaSalida = $('#fecchasalida').datepicker('getDate');
			
			// Verifica si la fecha de salida es anterior a la de ingreso
			if (fechaSalida < fechaIngreso) {
				alert("La fecha de salida no puede ser menor que la fecha de ingreso.");
				$('#fecchasalida').val(''); // Limpia el campo si la validación falla
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
		$('#fechaingreso').datepicker('enable');
		$('#idcliente').select2().val(temp.idcliente).prop('disabled', false);

	});


	function btnEditarServicio(Val0, Val1, Val2, Val3, Val4, Val5, Val6, Val7, Val8){
		$.ajax({
			type: 'POST',
			url: base_url + '/servicio/edit',
			data: { idservicio: Val0, idcliente: Val1, idubicacion: Val2, idbanda: Val3, idcondicion: Val4, idneumatico: Val5, idrencauchadora: Val6, idtiposervicio: Val7, idusuario: Val8},
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
				$('#fecchasalida').val(temp.fecchasalida);
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




	$('#btnFiltroServicio').click(function(){
		debugger
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
			fecchasalida: $('#fecchasalida').val().toUpperCase(),
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
				debugger
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
		$('#fecchasalida').val('');
		$('#observacionsalida').val('');
		$('#idcondicion').select2().val(0).select2('destroy').select2();

	}


	function ValidarCamposVaciosServicio(){
		var error = 0;
		if ($('#idservicio').val() == ''){
			Resaltado('idservicio');
			error++;
		}
		if ($('#fechaingreso').val() == ''){
			Resaltado('fechaingreso');
			error++;
		}
		if ($('#idusuario').val() == ''){
			Resaltado('idusuario');
			error++;
		}
		if ($('#observacioningreso').val() == ''){
			Resaltado('observacioningreso');
			error++;
		}
		if ($('#idcliente').val() == ''){
			Resaltado('idcliente');
			error++;
		}
		if ($('#idtiposervicio').val() == ''){
			Resaltado('idtiposervicio');
			error++;
		}
		if ($('#idbanda').val() == ''){
			Resaltado('idbanda');
			error++;
		}
		if ($('#idneumatico').val() == ''){
			Resaltado('idneumatico');
			error++;
		}
		if ($('#idubicacion').val() == ''){
			Resaltado('idubicacion');
			error++;
		}
		if ($('#idrencauchadora').val() == ''){
			Resaltado('idrencauchadora');
			error++;
		}
		// if ($('#fecchasalida').val() == ''){
		// 	Resaltado('fecchasalida');
		// 	error++;
		// }
		// if ($('#observacionsalida').val() == ''){
		// 	Resaltado('observacionsalida');
		// 	error++;
		// }
		if ($('#idcondicion').val() == ''){
			Resaltado('idcondicion');
			error++;
		}
		if ($('#estado').val() == ''){
			Resaltado('estado');
			error++;
		}

		return error;
	}


	function Resaltado(id){
		$('#'+id).css('border-color', '#ef5350');
		$('#'+id).focus();
	}


	function CargartablaServicio(objeto){   
		$('#TablaServicio tr').not($('#TablaServicio tr:first')).remove();
		$.each(objeto, function(i, value) {
		var fila = '<tr>'+
			'<td hidden>'+(value.idservicio !== null ? value.idservicio : '')+'</td>'+
			'<td >'+(value.fechaingreso !== null ? value.fechaingreso : '')+'</td>'+
			'<td >'+(value.idcliente !== null ? value.idcliente : '')+'</td>'+
			'<td hidden>'+(value.nombreusuario !== null ? value.nombreusuario : '')+'</td>'+
			'<td hidden>'+(value.idusuario !== null ? value.idusuario : '')+'</td>'+
			'<td >'+(value.observacioningreso !== null ? value.observacioningreso : '')+'</td>'+			
			'<td>'+(value.nombretiposervicio !== null ? value.nombretiposervicio : '')+'</td>'+
			'<td hidden>'+(value.idtiposervicio !== null ? value.idtiposervicio : '')+'</td>'+
			'<td>'+(value.nombrebanda !== null ? value.nombrebanda : '')+'</td>'+
			'<td hidden>'+(value.idbanda !== null ? value.idbanda : '')+'</td>'+
			'<td hidden>'+(value.idneumatico !== null ? value.idneumatico : '')+'</td>'+
			'<td>'+(value.nombretipoubicacion !== null ? value.nombretipoubicacion : '')+'</td>'+
			'<td hidden>'+(value.idubicacion !== null ? value.idubicacion : '')+'</td>'+
			'<td>'+(value.nombrereencauchadora !== null ? value.nombrereencauchadora : '')+'</td>'+
			'<td hidden>'+(value.idrencauchadora !== null ? value.idrencauchadora : '')+'</td>'+
			'<td >'+(value.fecchasalida !== null ? value.fecchasalida : '')+'</td>'+
			'<td >'+(value.observacionsalida !== null ? value.observacionsalida : '')+'</td>'+
			'<td>'+(value.nombrecondicion !== null ? value.nombrecondicion : '')+'</td>'+
			'<td hidden>'+(value.idcondicion !== null ? value.idcondicion : '')+'</td>'+
			'<td class = "hidden -xs">' + ((value.estado == '1') ? 'ACTIVO' : 'DESACTIVO') + '</td>'+

			'<td>'+
				'<div class="row">'+
					'<div style="margin: auto;">'+
						'<button type="button" onclick="btnEditarServicio(\''+value.idservicio+'\', \''+value.idcliente+'\', \''+value.idubicacion+'\', \''+value.idbanda+'\', \''+value.idcondicion+'\', \''+value.idneumatico+'\', \''+value.idrencauchadora+'\', \''+value.idtiposervicio+'\', \''+value.idusuario+'\')" class="btn btn-info btn-xs">'+
							'<span class="fa fa-search fa-sm"></span>'+
						'</button>'+
					'</div>'+
						'<div style="margin: auto;">'+
							'<a class="btn btn-success btn-xs" href="<?php echo base_url();?>/reserva/add"><i class="fa fa-pencil"></i></a>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>';
		$('#TablaServicio tbody').append(fila);
		});
	}


	function addEstado(i){
		$('#estado_'+i).append($('<option>').val('1').text('ACTIVO'));
		$('#estado_'+i).append($('<option>').val('0').text('DESACTIVO'));
	}


</script>
