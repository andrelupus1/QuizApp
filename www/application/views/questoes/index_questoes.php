<!-- Paginas -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Questões
            <small>Banco de Questões Cadastrados no Sistema</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('/'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Questões</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="<?=base_url('/questoes/add'); ?>" title="Cadastrar Questão" class="btn btn-primary btn-sm">Adicionar Questão</a>
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
                    echo "<pre>Não há Questões cadastrados</pre>";
                } else {
                    ?>
                    <table class="table table-striped table-hover" id="dataTables-dados">
                        <thead>
                            <tr>
                                <th style="width: 15%">Tema</th>
                                <th style="width: 10%">Disciplina</th>
                                <th style="width: 15%">Tipo de Prova</th>
                                <th style="width: 35%">Enunciado</th>
                                <th style="width: 10%">Ano</th>
                                <th style="width:15%">Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($lista as $ls) { 
                                    // resgata tema e subtema
                                    $tema = $this->questoes->getTemaId($ls->idTema);
                                                                    
                                    if($ls->idsubtemas != 0){
                                        // busca tema
                                        $subtema = $this->questoes->getSubtemaId($ls->idsubtemas);    
                                        
                                        $tema_questao = $tema->nomeTema." <br /> <small>".$subtema->nomeSubtema."</small>";
                                    }else{
                                        $tema_questao = $tema->nomeTema;
                                    }
                                    
                                    // resgata tipo de prova
                                    $tipo = $this->questoes->getTipoProvaID($ls->idtipo_prova);
                                    // resgata disciplina
                                    $disciplina = $this->questoes->getDisciplinaID($ls->idDisciplina);
                            ?>
                                <tr>
                                    <td><?php echo $tema_questao; ?></td>
                                    <td><?php echo $disciplina->nomeDisciplina; ?></td>
                                    <td><?php echo $tipo->tipoProva; ?></td>
                                    <td><?php echo $ls->enunciadoQuestao; ?></td>
                                    <td><?php echo $ls->anoQuestao; ?></td>
                                    <td>
                                        <?php
                                            echo anchor('/questoes/alternativas/' . $ls->idquestoes, '<i class="glyphicon glyphicon-list"></i>', 'class="btn btn-info btn-sm"') . "&nbsp;";
                                            echo anchor('/questoes/editar/' . $ls->idquestoes, '<i class="glyphicon glyphicon-edit"></i>', 'class="btn btn-info btn-sm"') . "&nbsp;";
                                        ?>
                                        <a href="javascript:void()" title="Deletar Questão" class="btn btn-danger btn-sm" onclick="delReg(<?=$ls->idquestoes?>)"><i class="glyphicon glyphicon-trash"></i></a>
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
<div class="modal fade" id="delReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form action="<?=base_url('/questoes/del_questao'); ?>" method="post"> 
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Deletar Questão</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <b>Atenção!</b> Você deseja realmente excluir este registro? <br />
                    Após a confirmação as alternativas vinculadas a mesma também serão deletadas.
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-danger">Excluir</button>
              <input type="hidden" name="questao" id="questao" />
            </div>
        </form>
    </div>
  </div>
</div>

<script type="text/javascript">
function delReg(id){
    $('#delReg').modal('show');
    $('#questao').val(id);
}
</script>