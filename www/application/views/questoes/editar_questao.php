<!-- Paginas -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cadastrar Questões
            <small>Cadastrar nova questão no Sistema</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('/'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('/questoes'); ?>">Questoes</a></li>
            <li class="active">Atualizar Questão</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
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
                ?>
                <form action="<?=base_url('/questoes/editar/'.$questao->idquestoes); ?>" method="post">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Tipo de Prova*</label>
                                <select name="tipoprova" class="form-control" required>
                                    <option value="">Selecione</option>
                                    <?php
                                        if(count($tipoProva) > 0):
                                            foreach($tipoProva as $tp):
                                                if($tp->idtipo_prova == $questao->idtipo_prova){
                                                    $selectTipo = 'selected="selected"';
                                                }else{
                                                    $selectTipo = '';
                                                }
                                                echo '<option value="'.$tp->idtipo_prova.'" '.$selectTipo.'>'.$tp->tipoProva.'</option>';
                                            endforeach;
                                        endif;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Disciplina*</label>
                                <select name="disciplina" class="form-control" onchange="slcDisciplina(this.value)" required>
                                    <option value="">Selecione</option>
                                    <?php
                                        if(count($disciplina) > 0):
                                            // resgata subtema para seleção da disciplina na tabela de tema
                                            $subtema = $this->questoes->getSubtemaId($questao->idsubtemas);
                                            $tema = $this->questoes->getTemaId($subtema->idtema);
                                            foreach($disciplina as $dsc):
                                                if($questao->idDisciplina == $dsc->iddisciplinas){
                                                    $selectDisc = 'selected="selected"';
                                                }else{
                                                    $selectDisc = '';
                                                }
                                                echo '<option value="'.$dsc->iddisciplinas.'" '.$selectDisc.'>'.$dsc->nomeDisciplina.'</option>';
                                            endforeach;
                                        endif;
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Tema da Questão*</label>
                                <select name="tema" class="form-control slcTema" onchange="slcTema(this.value)" required>
                                    <option>Selecione</option>
                                    <?php
                                        if(count($temas) > 0){
                                            foreach($temas as $tm):
                                                if($tm->idtema == $questao->idTema){
                                                    $slctTema = 'selected="selected"';
                                                }else{
                                                    $slctTema = '';
                                                }
                                                echo '<option value="'.$tm->idtema.'" '.$slctTema.'>'.$tm->nomeTema.'</option>';
                                            endforeach;
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Subtema da Questão*</label>
                                <select name="subtema" class="form-control slcSubTema" required>
                                    <option>Selecione</option>
                                    <?php
                                        if(count($subtemas) > 0){
                                            foreach($subtemas as $sbt):
                                                if($sbt->idsubtemas == $questao->idsubtemas){
                                                    $selectSubt = 'selected="selected"';
                                                }else{
                                                    $selectSubt = '';
                                                }
                                                echo '<option value="'.$sbt->idsubtemas.'" '.$selectSubt.'>'.$sbt->nomeSubtema.'</option>';
                                            endforeach;
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Ano da Questão*</label>
                                <input type="number" class="form-control" name="ano" value="<?=$questao->anoQuestao; ?>" required />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Número da Questão</label>
                                <input type="number" class="form-control" name="numero" value="<?=$questao->numQuestao; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Imagem</label> <br />                                                                                 
                                <?php
                                    if($questao->imgQuestao == ""){
                                        $btnTitulo = 'Cadastrar';
                                    }else{
                                        $btnTitulo = 'Atualizar';
                                        echo '<img src="'.base_url('/uploads/questoes/'.$questao->imgQuestao).'" class="img-thumbnail" style="max-height: 250px" /> <br />';
                                        echo anchor('/questoes/delImagem/'.$questao->idquestoes, 'Excluir Imagem', 'class="btn btn-sm btn-danger"');
                                    }
                                ?>
                               
                                <a href="javascript:void()" title="<?=$btnTitulo; ?> imagem" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#mdlImagem"><?=$btnTitulo?> imagem</a>
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Enunciado da Questão*</label>
                                <textarea id="texto1" name="enunciado" class="form-control" required><?=$questao->enunciadoQuestao; ?></textarea>
                                <?php echo @display_ckeditor($ckeditor_texto); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Comentário da Questão</label>
                                <textarea id="texto2" name="comentario" class="form-control"><?=$questao->comentarioQuestao; ?></textarea>
                                <?php echo @display_ckeditor($ckeditor_texto2); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="0" <?=($questao->statusQuestao == 0) ? 'selected' : ''; ?>>Inativa</option>
                                    <option value="1" <?=($questao->statusQuestao == 1) ? 'selected' : ''; ?>>Em Rascunho</option>
                                    <option value="2" <?=($questao->statusQuestao == 2) ? 'selected' : ''; ?>>Publicada</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" value="Salvar" class="btn btn-info" />
                            <input type="hidden" name="questao" value="<?=$questao->idquestoes; ?>" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="mdlImagem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form action="<?=base_url('/questoes/editarImagem/'.$questao->idquestoes); ?>" method="post" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=$btnTitulo ?> imagem</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
              <label>Nova Imagem</label>
              <input type="file" name="userfile" class="form-control" />
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <input type="hidden" name="questao" value="<?=$questao->idquestoes; ?>" />
      </div>
    </form>
    </div>
  </div>
</div>

<script type="text/javascript">
function slcDisciplina(id){
    $.ajax({
        type: 'POST',
        data: {'id':id},
        url: '<?=base_url('questoes/slcTemas');?>',
        beforesend:function(){
            $('.slcTema').html('<option>Carregando Temas...</option>');
        },
        success: function(response){
            $('.slcTema').html(response);
        },
        error: function(error){
            $('.slcTema').val(error.error);
        }
    });
}    
function slcTema(id){
    $.ajax({
        type: 'POST',
        data: {'id':id},
        url: '<?=base_url('questoes/slcSubtema');?>',
        beforesend:function(){
            $('.slcSubTema').html('<option>Carregando Subtemas...</option>');
        },
        success: function(response){
            $('.slcSubTema').html(response);
        },
        error: function(error){
            $('.slcSubTema').val(error.error);
        }
    });
}    
</script>