<!-- Paginas -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Temas/Subtemas
            <small>Temas/Subtemas Cadastrados no Sistema</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('/'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Temas/Subtemas</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="box-title">
                            <!-- Button trigger modal -->
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addTema">
                                Adicionar Tema
                            </button>
                        </h3>
                    </div>
                    <div class="col-md-6">
                        <form action="<?=base_url('questoes/temas')?>" type="GET">
                            <div class="input-group">
                                <input type="text" name="d" value="<?=($this->input->get('d') != "") ? $this->input->get('d') : ''; ?>" class="form-control" placeholder="Buscar Disciplina">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">Buscar</button>
                                </span>
                            </div><!-- /input-group -->
                        </form>
                    </div>
                </div>
                
                
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
                
                if($this->input->get('d') != ""){
                    echo '<pre>Listagem filtrada pelo termo: <b>'.$this->input->get('d').'</b></pre>';
                }
                
                if (count($temas) == 0) {
                    echo "<pre>Não há Temas cadastrados</pre>";
                } else {
                    ?>
                    
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <?php
                            foreach ($temas as $ln):
                                // resgata nome da disciplina
                                $n_disc = $this->questoes->getDisciplinaID($ln->iddisciplinas);
                        ?>
                        <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="headingOne_<?=$ln->idtema;?>">
                              <div class="row">
                                  <div class="col-md-8 text-left">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#tema_<?=$ln->idtema;?>" aria-expanded="true" aria-controls="collapseOne">
                                            <?=$ln->nomeTema; ?><br />
                                            <small>Disciplina: <?=$n_disc->nomeDisciplina?></small>
                                          </a>
                                        </h4>
                                  </div>
                                  <div class="col-md-4 text-right">
                                      <a href="javascript:void()" title="Adicionar Subtema" class="btn btn-sm btn-primary" onclick="addSubtema(<?=$ln->idtema?>)"><i class="glyphicon glyphicon-plus"></i> Subtema</a>
                                      <a href="javascript:void()" title="Editar" class="btn btn-sm btn-info" onclick="editTema(<?=$ln->idtema?>, <?=$ln->iddisciplinas?>, '<?=$ln->nomeTema?>')"><i class="glyphicon glyphicon-edit"></i></a>
                                      <a href="javascript:void()" title="Excluir" class="btn btn-sm btn-danger" onclick="delTema(<?=$ln->idtema?>, '<?=$ln->nomeTema?>')"><i class="glyphicon glyphicon-trash"></i></a>
                                  </div>
                              </div>
                            
                          </div>
                          <div id="tema_<?=$ln->idtema;?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_<?=$ln->idtema;?>">
                            <div class="panel-body">
                                <?php
                                    // resgata subtemas
                                    $subtemas = $this->questoes->getSubtemas($ln->idtema);
                                    if(count($subtemas) == 0){
                                        echo '<pre>Não há subtemas cadastrados.</pre>';
                                    }else{
                                ?>
                                    <table class="table table-hover table-striped table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Subtema</th>
                                                <th style="width: 10%">Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($subtemas as $st): ?>
                                            <tr>
                                                <td><?=$st->nomeSubtema; ?></td>
                                                <td>
                                                    <a href="javascript:void()" title="Editar" class="btn btn-sm btn-info" onclick="ediSubtema(<?=$st->idsubtemas?>, '<?=$st->idtema?>', '<?=$st->nomeSubtema?>')"><i class="glyphicon glyphicon-edit"></i></a>
                                                    <a href="javascript:void()" title="Excluir" class="btn btn-sm btn-danger" onclick="delSubtema(<?=$st->idsubtemas?>, '<?=$st->nomeSubtema?>')"><i class="glyphicon glyphicon-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php } ?>
                                
                            </div>
                          </div>
                        </div>
                        <?php endforeach; ?>
                    </div><!--.panel-group-->
                    
                <?php } ?>

            </div><!--.box-body-->
        </div><!--.box-->
    </section>
</div><!--.content-wrapper-->

<!-- Modal ADD Registro -->
<div class="modal fade" id="addTema" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php echo form_open('/questoes/add_tema'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Adicionar Tema</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Tema</label>
                            <input type="text" class="form-control" name="nome" required />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Disciplina</label>
                            <select name="disciplina" class="form-control" required>
                                <option value="">Selecione</option>
                                <?php
                                    if(count($disciplinas) > 0){
                                        foreach($disciplinas as $disc):
                                            echo '<option value="'.$disc->iddisciplinas.'">'.$disc->nomeDisciplina.'</option>';
                                        endforeach;
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
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
<div class="modal fade" id="upTema" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php echo form_open('/questoes/up_tema'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Atualizar Tema</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Tema</label>
                            <input type="text" class="form-control nomeTema" name="nome" required />
                            <input type="hidden" class="idTema" name="tema" required />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Disciplina</label>
                            <select name="disciplina" class="form-control idDisciplina" required>
                                <option value="">Selecione</option>
                                <?php
                                    if(count($disciplinas) > 0){
                                        foreach($disciplinas as $disc):
                                            echo '<option value="'.$disc->iddisciplinas.'">'.$disc->nomeDisciplina.'</option>';
                                        endforeach;
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
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
<div class="modal fade" id="delTema" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php echo form_open('/questoes/del_tema'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Excluir Tema</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <b>Atenção!</b> Você deseja realmente excluir este registro <b class="n_tema"></b>?<br />
                    Caso haja algum registro vinculado, esta ação não será permitida.                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Excluir</button>
                <input type="hidden" class="idtema" name="tema" />
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<!------- SUBTEMAS ------>
<!-- Modal ADD Registro -->
<div class="modal fade" id="addSubTema" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php echo form_open('/questoes/add_subtema'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Adicionar Subtema</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Subtema</label>
                            <input type="text" class="form-control" name="nome" required />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tema</label>
                            <select name="tema" class="form-control slcTema" required>
                                <option value="">Selecione</option>
                                <?php
                                    if(count($temas) > 0){
                                        foreach($temas as $tm):
                                            echo '<option value="'.$tm->idtema.'">'.$tm->nomeTema.'</option>';
                                        endforeach;
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
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
<div class="modal fade" id="upSubTema" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php echo form_open('/questoes/up_subtema'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Atualizar Subtema</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Subtema</label>
                            <input type="text" class="form-control nSubtema" name="nome" required />
                            <input type="hidden" class="subtema" name="idsub" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tema</label>
                            <select name="tema" class="form-control slcTema2" required>
                                <option value="">Selecione</option>
                                <?php
                                    if(count($temas) > 0){
                                        foreach($temas as $tm):
                                            echo '<option value="'.$tm->idtema.'">'.$tm->nomeTema.'</option>';
                                        endforeach;
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
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
<div class="modal fade" id="delSubtema" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php echo form_open('/questoes/del_subtema'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Excluir Subtema</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <b>Atenção!</b> Você deseja realmente excluir este registro <b class="n_subtema"></b>?<br />
                    Caso haja algum registro vinculado, esta ação não será permitida.                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Excluir</button>
                <input type="hidden" class="idsubtema" name="tema" />
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
function editTema(id, disciplina, nome){
    $('#upTema').modal('show');
    $('.nomeTema').val(nome);
    $('.idDisciplina').val(disciplina);
    $('.idTema').val(id);
}    
function delTema(id, nome){
    $('#delTema').modal('show');
    $('.n_tema').html(nome);
    $('.idtema').val(id);
}    
function addSubtema(tema){
    $('#addSubTema').modal('show');
    $('.slcTema').val(tema);
}
function ediSubtema(id, tema, nome){
    $('#upSubTema').modal('show');
    $('.nSubtema').val(nome);
    $('.slcTema2').val(tema);
    $('.subtema').val(id);
}
function delSubtema(id, nome){
    $('#delSubtema').modal('show');
    $('.n_subtema').html(nome);
    $('.idsubtema').val(id);
}
</script>