<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema de control de reencauche | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>public/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>public/plugins/font-awesome/css/font-awesome.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url();?>public/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
     <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?php echo base_url();?>public/plugins/datepicker/css/bootstrap-datepicker.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url();?>public/plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url();?>public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="<?php echo base_url();?>public/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="<?php echo base_url();?>public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url();?>public/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="<?php echo base_url();?>public/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url();?>public/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url();?>public/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- Autocomplete -->
    <link rel="stylesheet" href="<?php echo base_url();?>public/asset/css/jquery-ui.css">

    <!-- jQuery -->
<script src="<?php echo base_url();?>public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url();?>public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- fullCalendar 2.2.5 -->
<!-- ClockPicker -->
<script src="<?php echo base_url();?>public/asset/js/moment.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url();?>public/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>public/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url();?>public/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="<?php echo base_url();?>public/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="<?php echo base_url();?>public/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url();?>public/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url();?>public/plugins/datepicker/js/bootstrap-datepicker.js"></script>
<!-- date-range-picker -->
<script src="<?php echo base_url();?>public/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url();?>public/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url();?>public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>public/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>public/dist/js/demo.js"></script>
<!-- Autocomplete-->
<script src="<?php echo base_url();?>public/asset/js/jquery-ui.js"></script> 

<!-- Full Calendar -->
<link rel="stylesheet" href="<?php echo base_url();?>public/asset/css/fullcalendar.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>public/asset/css/bootstrap-clockpicker.css">
<!-- <link rel="stylesheet" href="<?php echo base_url();?>public/asset/css/mystyle.css"> -->
<script src="<?php echo base_url();?>public/asset/js/fullcalendar.min.js"></script>
<script src="<?php echo base_url();?>public/asset/js/es.js"></script>
<script src="<?php echo base_url();?>public/asset/js/bootstrap-clockpicker.js"></script>
<script src="<?php echo base_url();?>public/asset/js/moment.min.js"></script>
<!-- LIBRERIAS NUEVAS -->
<script src="<?php echo base_url();?>public/dist/js/libreriatato.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<!-- Bootstrap Switch -->
<!-- <script src="<?php echo base_url();?>public/plugins/bootstrap4-toggle/js/bootstrap4-toggle.js"></script>
<script src="<?php echo base_url();?>public/plugins/bootstrap4-toggle/css/bootstrap4-toggle.css"></script> -->
<style type="text/css">

.numeroDerecha{
  text-align: right;
}

.ui-datepicker { position: relative; z-index: 10000 !important; }

.form-control-xs {
    height: calc(1em + .375rem + 2px) !important;
    padding: .125rem .25rem !important;
    font-size: .75rem !important;
    line-height: 1.5;
    border-radius: .2rem;
}

  .btn-tato{
    padding: .5rem .55rem; 
    font-size: .875rem;
    line-height: 1.5;
    border-radius: .2rem;
  }

	#loading-wrap {
		position:fixed;
		height:100%;
		width:100%;
		overflow:hidden;
		top:0;
		left:0;
		display:block;
		background: white url(/wait30trans.gif) no-repeat center center;
		z-index:999;
	}

  #modalAddCliente {
    z-index: 1052; /* Valor alto para asegurar que esté por encima */
  }

  #modalAddCliente .modal-backdrop {
      z-index: 1051; /* Ajusta el z-index del backdrop para que esté detrás del modal */
  }

  /* Para dispositivos móviles (pantallas pequeñas) */
	@media (max-width: 574.98px) {
		.select2-container{
			width: 87% !important;
		}
	}

	/* Para dispositivos de tamaño mediano (tabletas) */
	@media (min-width: 575px) and (max-width: 991.98px) {
		.select2-container{
			width: 81% !important;
		}
	}
	
	/* Para pantallas grandes (laptops) */
	@media (min-width: 992px) and (max-width: 1199.98px) {
		.select2-container{
			width: 89% !important;
		}
	}

	/* Para pantallas extra grandes (monitores grandes) */
	@media (min-width: 1200px) {
		.select2-container{
			width: 93% !important;
		}
	}

  .demo-content {
      width: 100%;
    }
  
  @media screen and (max-width: 992px) {
    .demo-content {
      /*background: #e7e8e8 none repeat scroll 0 0 !important;
      overflow: scroll;
      max-width: 992px;*/
      width: 100%;
      overflow-x: scroll;
    }

    .demo-content::-webkit-scrollbar-track, .demo-content-precio::-webkit-scrollbar-track {
        /* -webkit-box-shadow: inset 0 0 4px #000000; */
        border-radius: 10px;
        background-color: #f1f1f1;
    }

    .demo-content::-webkit-scrollbar, .demo-content-precio::-webkit-scrollbar {
        width: 30px;
        background-color: #f1f1f1;
    }

    .demo-content::-webkit-scrollbar-thumb, .demo-content-precio::-webkit-scrollbar-thumb {
        border-radius: 10px;
        /* -webkit-box-shadow: inset 0 0 4px #000000; */
        background-color: #3bafda;
    }
  }
	.modal-header{
		padding: .2rem 1rem;
	}
	.modal-body{
		padding: .5rem 1rem .2rem 1rem;
	}
	.modal-footer{
		padding: .2rem .75rem;
	}
	.card-body{
		padding: .5rem;
	}

  table.dataTable tbody th, table.dataTable tbody td {
      padding: 0.4rem;
  }

  .ui-autocomplete, .ui-menu, .ui-menu-item {  
      z-index: 1500; 
  }

  .form-group {
      margin-bottom: 0.5rem !important;
  }

  div.scroll { 
      width: 100%; 
      /*overflow: auto; */
  } 
</style>
</head>
<body class="hold-transition sidebar-mini text-sm">
<div class="wrapper">
<!-- <div id="loading-wrap" hidden>
<div> -->
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?php echo base_url();?>publicindex3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>
    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo base_url();?>public/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo base_url();?>public/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?php echo base_url();?>public/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      </ul>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="nav-item has-treeview menu-open">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style = "color: #000">
                    <span class="fa fa-user"></span>
                    <!-- <span class="hidden-xs"><php echo $this->session->userdata("nombre")?></span> -->
                </a>
                <ul class="dropdown-menu">
                    <li class="nav-item">
                      <a href="#" class="nav-link" data-toggle="modal" data-target="#modal-password">
                        <p><i class="nav-icon fa fa-cogs"></i> Contraseña</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo base_url(); ?>login/logout" class="nav-link">
                      <p><i class="nav-icon fa fa-chevron-left"></i> Cerrar Sesíon</p>
                      </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
  </nav>

  <div class="modal fade" id="modal-auditoria">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class='modal-title' id='modaldeltalletour'>Detalle Auditoria</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="menu_arbol_usuario">
              <div class='demo-content scroll'>
                <table id='HeaderTablaAuditoria' class='table table-sm table-bordered table-striped'>
                  <thead>
                    <tr>
                      <th hidden>Idauditoria</th>
                      <th hidden>Idservicio</th>
                      <th>Campo_Modificado</th>
                      <th>Valor_Anterior</th>
                      <th>Valor_Nuevo</th>
                      <th>Fecha_Modificacion</th>
                      <th>Usuario_Modificacion</th>
                      <th>Estado</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-info pull-right" data-dismiss="modal">Aceptar</button>
              </div>
          </div>
      </div>
  </div>

  <!-- /.navbar -->
  <div class="modal fade" id="modal-password">
    <div class="modal-dialog modal-md">
      <div class='modal-content'>
          <?php if (session()->getFlashdata('error')): ?>
              <p style="color:red;"><?= session()->getFlashdata('error') ?></p>
              <script>
                  $(document).ready(function() {
                      $('#modal-password').modal('show');
                  });
              </script>
          <?php endif; ?>

          <?php if (session()->getFlashdata('success')): ?>
              <p style="color:green;"><?= session()->getFlashdata('success') ?></p>
              <script>
                  $(document).ready(function() {
                      $('#modal-password').modal('show');
                  });
              </script>
          <?php endif; ?>
          <form action="<?= base_url('usuario/changePassword') ?>" method="post">
            <div class='modal-header'>
              <h4 class='modal-title' id='modaldeltalletour'>Detalle Usuario</h4>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>×</span>
              </button>
            </div>        
            <div class='modal-body'>
              <div class='form-group row'>
                <div class='col-12 form-group row'>
                  <label for = current_password class='col-sm-4'>Contraseña actual:</label>
                  <div class = 'col-sm-8'>
                    <input type='password' class='form-control form-control-sm' id='current_password' name='current_password' required>
                  </div>
                </div>
              </div>
              <div class='form-group row'>
                <div class='col-12 form-group row'>
                  <label for = new_password class='col-sm-4'>Nueva contraseña:</label>
                  <div class = 'col-sm-8'>
                    <input type='password' class='form-control form-control-sm' id='new_password' name='new_password' required>
                  </div>
                </div>
              </div>
              <div class='form-group row'>
                <div class='col-12 form-group row'>
                  <label for = confirm_password class='col-sm-4'>Nueva contraseña:</label>
                  <div class = 'col-sm-8'>
                    <input type='password' class='form-control form-control-sm' id='confirm_password' name='confirm_password' required>
                  </div>
                </div>
              </div>
            </div> 
            <div class="modal-footer">
              <button type="submit" class="btn btn-success pull-left">Cambiar Contraseña</button>
              <button type="reset" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
            </div> 
          </form> 
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-default-alerta">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="menu_arbol_usuario">
                <label id="labelalerta"></label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info pull-right" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<div id="modal-overlay" class="modal fade" data-backdrop="false" data-keyboard="false" tabindex="-1" role="dialog" style="z-index: 20000;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <img style="margin: 0 auto" src="<?php echo base_url();?>public/wait30trans.gif" />
    </div>
</div>
<div class="modal fade" id="modal-default-alerta">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="menu_arbol_usuario">
                <label id="labelalerta"></label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info pull-right" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>


