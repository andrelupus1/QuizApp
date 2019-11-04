<!-- Paginas -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Usuários do APP
            <small>Usuários cadastrados para uso no APP</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('/'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Usuários APP</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
            </div>
           
            <div class="box-body">
                <h3 class="box-title">
                    <!-- Button trigger modal -->
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addAdmin">
                        Adicionar Usuário
                    </button>
                </h3>
                <?php
                if ($this->session->flashdata('sucesso')) {
                    echo '<div class="alert alert-success" style="margin: 20px">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                ' . $this->session->flashdata('sucesso') . '
                            </div>';
                }
                if ($this->session->flashdata('error')) {
                    echo '<div class="alert alert-danger" style="margin: 20px">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                ' . $this->session->flashdata('error') . '
                            </div>';
                }
                if (count($admin) == 0) {

                    echo "<pre>Não há administradores cadastrados</pre>";
                } else {
                    ?>
                    <table class="table table-striped table-hover" id="dataTables-dados">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuários</th>
                                <th>E-mail</th>
                                <th>CRM</th>
                                <th>Opções></th/>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($admin as $ad) { ?>
                                <tr>
                                    <td><?php echo $ad->idusuarios; ?></td>
                                    <td><?php echo $ad->nomeUsuario; ?></td>
                                    <td><?php echo $ad->emailUsuario; ?></td>
                                    <td><?php echo $ad->crmUsuario; ?></td>
                                    <td>
                                        <?php
                                        echo anchor('/usuarios/editarApp/' . $ad->idusuarios, '<i class="glyphicon glyphicon-edit"></i>', 'class="btn btn-info"') . "&nbsp;";
                                        echo anchor('/usuarios/excluirApp/' . $ad->idusuarios, '<i class="glyphicon glyphicon-trash"></i>', 'class="btn btn-danger" onclick="return confirm("Confirma exclusão do Administrador?")"');
                                        ?>
                                        </td>
                                    
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>

            </div><!--.box-body-->
        </div><!--.box-->

    </section>
</div><!--.content-wrapper-->

<!-- Modal -->
<div class="modal fade" id="addAdmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php echo form_open('/usuarios/addApp'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Adicionar Usuário</h4>
            </div>
            <div class="modal-body">
                <?php
                echo '<span class="validacao"> ' . validation_errors() . ' </span>';

                echo form_fieldset();

                echo '<div class="form-group">';
                echo '<label>Nome Usuário</label>';
                echo form_input('txtNome', set_value('txtNome'), 'class="form-control"');
                echo '</div>';

                echo '<div class="form-group">';
                echo '<label>E-mail</label>';
                echo form_input('txtEmail', set_value('txtEmail'), 'class="form-control"');
                echo '</div>';

                echo '<div class="form-group">';
                echo '<label>Senha</label>';
                echo form_password('txtSenha', set_value('txtSenha'), 'class="form-control"');
                echo '</div>';

                echo '<div class="form-group">';
                echo '<label>Confirmar Senha</label>';
                echo form_password('txtSenha2', set_value('txtSenha2'), 'class="form-control"');
                echo '</div>';

                echo form_fieldset_close();
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <?php
                $atrBt = array("name" => "btn", "value" => "Cadastrar", "class" => "btn btn-primary");
                echo form_submit($atrBt);
                ?>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
