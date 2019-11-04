<!-- Paginas -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Alternativas
            <small>Alternativas da questão</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('/'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('/questoes'); ?>"> Questoes </a></li>
            <li class="active">Alternativas</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <div class="msg_retorno"></div>
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
                ?>
                <div class="form-group">
                    <label>Enunciado da Questão</label><br />
                    <?=(!empty($questao->imgQuestao)) ? '<img src="'.base_url('/uploads/questoes/'.$questao->imgQuestao).'" class="img-responsive" /> <br />' : '';?>
                    <?=$questao->enunciadoQuestao; ?>                                       
                </div>
            </div><!--.box-body-->
        </div><!--.box-->
        
        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <a href="javascript:void()" title="Adicionar Alternativa" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addAlternativa">Adicionar Alternativa</a>
                    </div>
                </div>
                <hr />
                <?php
                    if(count($alternativas) == 0){
                        echo '<pre>Não há alternativas cadastradas até o momento.</pre>';
                    }else{
                        echo '<table class="table table-hover table-striped">';
                        echo '<thead>';
                            echo '<tr>';
                                echo '<th style="width: 5%">Correta</th>';
                                echo '<th style="width: 45%">Alternativa</th>';
                                echo '<th style="width: 40%">Comentário</th>';
                                echo '<th style="width: 10%">Opções</th>';
                            echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        foreach($alternativas as $alt):
                            // marca a opção correta
                            if($alt->alternativaCorreta == 1){
                                $check = 'checked="checked"';
                            }else{
                                $check = '';
                            }
                            echo '<tr>';                        
                                echo '<td><input type="radio" name="altCorreta" value="'.$alt->id_alternativas.'" onclick="checkCorreta('.$alt->id_alternativas.')" '.$check.' /></td>';
                                echo '<td>'.$alt->enunciadoAlternativa.'<input type="hidden" name="enunciado" class="alternativa_'.$alt->id_alternativas.'" value="'.strip_tags($alt->enunciadoAlternativa).'" /></td>';
                                echo '<td>'.$alt->comentarioAlternativa.'</td>';
                                echo '<td>';
                                    echo '<a href="javascript:void()" title="Editar Alternativa" class="btn btn-sm btn-info" onclick="edireg('.$alt->id_alternativas.')"><i class="glyphicon glyphicon-edit"></i></a> ';
                                    echo ' <a href="javascript:void()" title="Deletar Alternativa" class="btn btn-sm btn-danger" onclick="delReg('.$alt->id_alternativas.')"><i class="glyphicon glyphicon-trash"></i></a>';
                                echo '</td>';
                            echo '</tr>';
                        endforeach;
                        echo '</tbody>';
                        echo '</table>';
                    }

                ?>
            </div><!--.box-body-->
        </div><!--.box-->
    </section>
</div><!--content-wrapper-->



<!-- Modal -->
<div class="modal fade" id="addAlternativa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="width: 80%">
    <div class="modal-content">
        <form action="<?=base_url('/questoes/alternativas'); ?>" method="post"> 
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Cadastrar Alternativa</h4>
            </div>
            <div class="modal-body">
                  <div class="form-group">
                      <label>Enunciado da Alternativa*</label>
                      <textarea id="texto1" name="enunciado" class="form-control" required></textarea>
                      <?php echo @display_ckeditor($ckeditor_texto); ?>
                  </div>
                  <div class="form-group">
                      <label>Comentário da Alternativa</label>
                      <textarea id="texto2" name="comentario" class="form-control" required></textarea>
                      <?php echo @display_ckeditor($ckeditor_texto2); ?>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Cadastrar</button>
              <input type="hidden" name="questao" value="<?=$questao->idquestoes?>" />
            </div>
        </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="delReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <form action="<?=base_url('/questoes/del_alternativa'); ?>" method="post"> 
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Deletar Alternativa</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <b>Atenção!</b> Você deseja realmente excluir este registro? <br />
                    <span class="e_alternativa"></span>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-danger">Excluir</button>
              <input type="hidden" name="questao" value="<?=$questao->idquestoes?>" />
              <input type="hidden" name="alternativa" id="alternativa" />
            </div>
        </form>
    </div>
  </div>
</div>

<script type="text/javascript">
function checkCorreta(alt){
    $.ajax({
        type: 'POST',
        data: {'questao': <?=$questao->idquestoes?>,'alternativa':alt},
        url: '<?=base_url('questoes/upcheck')?>',
        beforeSend: function(){
            $('.msg_retorno').html('<div class="alert alert-info">Aguarde, salvando alternativa correta...</div>');
        },
        success: function(response){
            $('.msg_retorno').html(response);
        },
        error: function(){
            $('.msg_retorno').html('<div class="alert alert-danger">Erro ao salvar alternativa correta, atualize sua página e tente novamente!</div>');
        }
    });
}    
function edireg(id){
    $.ajax({
        type: 'POST',
        data: {'alternativa':id},
        url: '<?=base_url('questoes/frmEditAlternativa')?>',
        beforeSend: function(){
            $('.msg_retorno').html('<div class="alert alert-info">Aguarde, salvando alternativa correta...</div>');
        },
        success: function(response){
            $('.msg_retorno').html(response);
            $('#editAlternativa').modal('show');    
            CKEDITOR.replace( 'texto1');
            CKEDITOR.replace( 'texto2');
        },
        error: function(){
            $('.msg_retorno').html('<div class="alert alert-danger">Erro ao salvar alternativa correta, atualize sua página e tente novamente!</div>');
        }
    });
}
function delReg(id){
    var enunciado = $('.alternativa_'+id).val();
    $('#delReg').modal('show');
    $('#alternativa').val(id);
    $('.e_alternativa').html(enunciado);
}
</script>