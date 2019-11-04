<!-- Paginas -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tipos de Provas
            <small>Tipos de Provas Cadastradas no Sistema</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('/'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Tipos de Provas</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <!-- Button trigger modal -->
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addTipo">
                        Adicionar Tipo
                    </button>
                </h3>
                
            </div>
            <div class="box-body">

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
                if (count($lista) == 0) {
                    echo "<pre>Não há Tipos de Provas cadastradas</pre>";
                } else {
                    ?>
                    <table class="table table-striped table-hover" id="dataTables-dados">
                        <thead>
                            <tr>
                                <th>Tipo de Prova</th>
                                <th style="width: 15%">Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lista as $ls) { ?>
                                <tr>
                                    <td><?php echo $ls->tipoProva; ?></td>
                                    <td>
                                        <a href="javascript:void()" title="Editar Tipo" onclick="editaReg(<?=$ls->idtipo_prova?>, '<?=$ls->tipoProva?>')" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-edit"></i></a>
                                        <a href="javascript:void()" title="Editar Tipo" onclick="delReg(<?=$ls->idtipo_prova?>, '<?=$ls->tipoProva?>')" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
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

<!-- Modal ADD Registro -->
<div class="modal fade" id="addTipo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php echo form_open('/questoes/add_tipo'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Adicionar Tipo de Prova</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Tipo de Prova</label>
                    <input type="text" class="form-control" name="tipo" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<!-- Modal UP Registro -->
<div class="modal fade" id="upTipo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php echo form_open('/questoes/up_tipo'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Atualizar Tipo de Prova</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Tipo de Prova</label>
                    <input type="text" class="form-control tipoProva" name="tipo" />
                    <input type="hidden" class="idProva" name="idtipo" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<!-- Modal Del Registro -->
<div class="modal fade" id="delTipo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php echo form_open('/questoes/del_tipo'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Excluir Tipo de Prova</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <b>Atenção!</b> Você deseja realmente excluir este registro <b class="n_tipo"></b>?<br />
                    Caso haja algum registro vinculado, esta ação não será permitida.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Excluir</button>
                <input type="hidden" id="idTipo" name="idtipo" />
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>


<script type="text/javascript">
function editaReg(id, tipo){
    $('#upTipo').modal('show');
    $('.tipoProva').val(tipo);
    $('.idProva').val(id);
}    
function delReg(id, tipo){
    $('#delTipo').modal('show');
    $('.n_tipo').html(tipo);
    $('#idTipo').val(id);
}    
</script>