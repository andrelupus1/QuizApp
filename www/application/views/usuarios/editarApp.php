<!-- Paginas -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Usuários
            <small>Usuários do APP cadastrados no site</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('/'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('/usuarios/app'); ?>"> Usuários do APP</a></li>
            <li class="active">Atualização de Cadastro</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                
                <?php

                              if($this->session->flashdata('sucesso')){
                                  echo '<div class="alert alert-success" style="margin: 20px">
                                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                                              <h4>Atenção!</h4>
                                              '.$this->session->flashdata('sucesso').'
                                          </div>';
                              }
                              if($this->session->flashdata('error')){
                                  echo '<div class="alert alert-danger" style="margin: 20px">
                                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                                              <h4>Atenção!</h4>
                                              '.$this->session->flashdata('error').'
                                          </div>';
                              }


                              echo form_open('/usuarios/editarApp/'.$admin->idusuarios);
                              echo '<span class="validacao"> '.  validation_errors().' </span>';
                              echo form_fieldset();

                              echo '<div class="form-group">';
                              echo '<label>Nome</label>';
                              echo form_input('txtNome', $admin->nomeUsuario, 'class="form-control"');
                              echo '</div>';

                              echo '<div class="form-group">';
                              echo '<label>E-mail</label>';
                              echo form_input('txtEmail', $admin->emailUsuario, 'class="form-control"');
                              echo '</div>';
                              //nick
                              echo '<div class="form-group">';
                              echo '<label>Nickname</label>';
                              echo form_input('txtNickname', $admin->nickName, 'class="form-control"');
                              echo '</div>';
                              
                              //Senha
                              echo '<div class="form-group">';
                              echo '<label>Senha</label>';
                              echo form_password('txtSenha','','class="form-control"');
                              echo '</div>';

                              echo '<div class="form-group">';
                              echo '<label>Confirmar Senha</label>';
                              echo form_password('txtSenha2', '', 'class="form-control"');
                              echo '</div>';

                              //crm
                              echo '<div class="form-group">';
                              echo '<label>CRM</label>';
                              echo form_input('txtCrm', $admin->crmUsuario, 'class="form-control"');
                              echo '</div>';

                              //status
                              echo '<div class="form-group">';
                              echo '<label>Status</label>';
                              echo form_input('txtStatus', $admin->status, 'class="form-control"');
                              echo '</div>';                        
                     
                             echo form_fieldset_close();


                              echo "<br /><br />";
                              echo form_hidden("nome", $admin->idusuarios);
                              echo anchor('/usuarios/app/', 'Voltar', 'class="label label-default"')."&nbsp;";
                              echo form_submit(array("class"=>"btn btn-primary", "name"=>"btSalvar", "value"=>"Salvar Dados"));
                              echo form_close();

                          ?>

                
            </div><!--.box-body-->
        </div><!--.box-->
    </section>
</div><!--.content-wrapper-->