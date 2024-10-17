        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url()?>" class="brand-link">
      <img src= "<?php echo base_url()?>public/uploads/logo/logo-footer-02.png" alt="Gestion de llantas" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Gestion de llantas</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url()?>public/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo session()->get('username')?></a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- <li class="header">MAIN NAVIGATION</li>  -->
            <li class="nav-item has-treeview menu-open">
                <a href="<?php echo base_url();?>servicio" class="nav-link">
                    <i class="nav-icon fa fa-calendar-check-o"></i>
                    <p>
                        Servicio
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url();?>cliente">
                        <i class="fa fa-users nav-icon"></i>
                        <p>Cliente</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url();?>tiposervicio">
                        <i class="fa fa-users nav-icon"></i>
                        <p>Tipo servicio</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url();?>reencauchadora">
                        <i class="fas fa-clock nav-icon"></i>
                        <p>Reeccauchadora</p>
                    </a>
                </li>                    
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url();?>neumatico">
                        <i class="fa fa-subway nav-icon"></i>
                        <p>Neumatico</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url();?>banda">
                    <i class="fa fa-subway nav-icon"></i>
                        <p>Banda</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url();?>condicion">
                        <i class="fa fa-file-pdf-o nav-icon"></i>
                        <p>Condicion</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url();?>ubicacion">
                        <i class="fa fa-map-marker nav-icon"></i>
                        <p>Ubicacion</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url();?>auditoria">
                        <i class="fa fa-search nav-icon"></i>
                        <p>Auditoria</p>
                    </a>
                </li>
            </li>              
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-clock"></i>
                    <p>
                        configuraciones
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">  
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>usuario">
                            <i class="fa fa-users nav-icon"></i>
                            <p>Usuarios</p>
                        </a>
                    </li>   
                </ul>
            </li> 
          <?php 
            // echo "<li class='nav-item has-treeview menu-open'>". fa fa-search fa-xs
            //  "<a href='#' class='nav-link active'>".
            //  "<i class='nav-icon fas fa-tachometer-alt'></i>".
            //  "<p>PORTAL WEB<i class='right fas fa-angle-left'></i></p>".
            //  "</a>";
            // echo "<ul class='nav nav-treeview'";            
            // foreach ($activo as $value) {
            //     $Menu2 = base_url().$value->Controller;
            //     $URL = current_url();
            //     if ($Menu2 == $URL) {
            //         echo "<li class = 'nav-item'><a href='".$Menu2."'>".
            //         "<i class='".$value->Icono."'></i><p>".$value->Nombre."</p></a>".
            //         "</li>";
            //     } else {
            //         echo "<li class = 'nav-item'>".
            //         "<a href='".$Menu2."' class='nav-link'>".
            //         "<i class='".$value->Icono."'></i><p>".$value->Nombre."</p></a>".
            //         "</li>";
            //     }  
            // }
            // echo "</ul>".
            // "</li>";            
        ?>
        </ul>        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>