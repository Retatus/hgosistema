  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.2
    </div>
    <strong>Copyright &copy; 2014-2020 <a href="https://www.facebook.com/Tatope-1629268083750486">Tato.pe</a>.</strong> All rights
    reserved.
  </footer>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- Page script -->

<script src="<?php echo base_url();?>public/hgo/js/bandaVista.js"></script>
<script src="<?php echo base_url();?>public/hgo/js/clienteVista.js"></script>
<script src="<?php echo base_url();?>public/hgo/js/condicionVista.js"></script>
<script src="<?php echo base_url();?>public/hgo/js/marcaVista.js"></script>
<script src="<?php echo base_url();?>public/hgo/js/medidaVista.js"></script>
<script src="<?php echo base_url();?>public/hgo/js/reencauchadoraVista.js"></script>
<script src="<?php echo base_url();?>public/hgo/js/tiposervicioVista.js"></script>
<script src="<?php echo base_url();?>public/hgo/js/ubicacionVista.js"></script>

<script>
  function btnVerAuditoria(Val0){
		$.ajax({
			type: 'POST',
			url: base_url + '/auditoria/headerAuditoria',
			data: {idservicio: Val0},
			success: function(msg){
				debugger
				var temp = JSON.parse(msg);
				console.log(temp);
        $('#HeaderTablaAuditoria tr').not($('#HeaderTablaAuditoria tr:first')).remove();
        $.each(temp, function(i, value) {
            var fila = `<tr>
            <td hidden>${value.idauditoria !== null ? value.idauditoria : ''}</td>
            <td>${value.campo_modificado !== null ? value.campo_modificado : ''}</td>
            <td>${value.valor_anterior !== null ? value.valor_anterior : ''}</td>
            <td>${value.valor_nuevo !== null ? value.valor_nuevo : ''}</td>
            <td>${value.fecha_modificacion !== null ? value.fecha_modificacion : ''}</td>
            <td>${value.usuario_modificacion !== null ? value.usuario_modificacion : ''}</td>
            <td class = 'hidden-xs'>${value.estado == '1' ? 'ACTIVO' : 'DESACTIVO'}</td>
            <td hidden>${value.idservicio !== null ? value.idservicio : ''}</td>				
            <td hidden>${value.concatenado !== null ? value.concatenado : ''}</td>
            <td hidden>${value.concatenadodetalle !== null ? value.concatenadodetalle : ''}</td>
            </tr>`
          $('#HeaderTablaAuditoria tbody').append(fila);
        });
				$('#modal-auditoria').modal('toggle');
			},
			error: function(){
				alert('Hay un error...');
			}
		});
	}
</script>

</body>
</html>

