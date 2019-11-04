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
            <li class="active">Cadastrar Questões</li>
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
                <form action="<?=base_url('/questoes/add'); ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Tipo de Prova*</label>
                                <select name="tipoprova" class="form-control" required>
                                    <option value="">Selecione</option>
                                    <?php
                                        if(count($tipoProva) > 0):
                                            foreach($tipoProva as $tp):
                                                echo '<option value="'.$tp->idtipo_prova.'">'.$tp->tipoProva.'</option>';
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
                                            foreach($disciplina as $dsc):
                                                echo '<option value="'.$dsc->iddisciplinas.'">'.$dsc->nomeDisciplina.'</option>';
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
                                    <option value="">Selecione</option>                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Subtema da Questão</label>
                                <select name="subtema" class="form-control slcSubTema">
                                    <option value="">Selecione</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Ano da Questão*</label>
                                <input type="number" class="form-control" name="ano" required />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Número da Questão</label>
                                <input type="number" class="form-control" name="numero" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Imagem</label>                                                                                   
                                <input type="file" name="userfile" class="form-control" /> 
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Enunciado da Questão*</label>
                                <textarea id="texto1" name="enunciado" class="form-control" required></textarea>
                                <?php echo @display_ckeditor($ckeditor_texto); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Comentário da Questão</label>
                                <textarea id="texto2" name="comentario" class="form-control"></textarea>
                                <?php echo @display_ckeditor($ckeditor_texto2); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="submit" value="Cadastrar" class="btn btn-primary" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
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