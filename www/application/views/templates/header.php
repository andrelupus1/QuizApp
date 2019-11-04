
  <header class="main-header">

    <!-- Logo -->
    <a href="<?=base_url('/home'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Oft</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Oft</b>Quiz</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=base_url('layout/img/user2-160x160.jpg'); ?>" class="user-image" alt="<?=$this->session->userdata('nome_usuario'); ?>">
              <span class="hidden-xs"><?=$this->session->userdata('nome_usuario'); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?=base_url('layout/img/user2-160x160.jpg'); ?>" class="img-circle" alt="<?=$this->session->userdata('nome_usuario'); ?>">

                <p>
                  <?=$this->session->userdata('nome_usuario'); ?>
                  <small><?=$this->session->userdata('email_usuario'); ?></small>
                </p>
              </li>
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                    <a href="<?=base_url('/usuarios/editar/'.$this->session->userdata('id')); ?>" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                    <a href="<?=base_url('/account/logout'); ?>" class="btn btn-default btn-flat">Sair</a>
                </div>
              </li>
            </ul>
          </li>
          
        </ul>
      </div>

    </nav>
  </header>
