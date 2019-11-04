<!-- Paginas -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Banners
            <small>Banners cadastrados no site</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('/banners'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Banners</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <?php echo anchor('#addBanner', '<i class="glyphicon glyphicon-plus"></i> Adicionar Banner', array('class' => 'btn btn-primary', 'data-toggle' => 'modal')); ?>
                </h3>
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
                    if ($this->session->flashdata('sucesso')) {
                        echo '<div class="alert alert-success" style="margin: 20px">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <h4>Atenção!</h4>
                                    ' . $this->session->flashdata('sucesso') . '
                                </div>';
                    }
                if (count($banner) == 0) {
                    echo "<pre>Não há banners cadastrados</pre>";
                } else {
                    ?>
                    <!-- button msg retorno -->
                    <div class="msg_retorno"></div>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th style="width: 80px">Ordem</th>
                                <th>Legenda</th>                                            
                                <th>URL</th>
                                <th>Banner</th>
                                <th>Status</th>
                                <th>Opções</th>
                                <th>Exibição</th>
                                <th>Cliques (Em breve)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($banner as $ln) { ?>
                                <tr>
                                    <td>
                                        <input type="number" name="txtOrdem" class="form-control ordemBanner" onblur="ordemBanner('<?php echo $ln->idBanner; ?>', this.value)"  value="<?php echo $ln->ordemBanner; ?>" min="1" >
                                    </td>
                                    <td><?php echo $ln->nomeBanner; ?></td>
                                    <td><?php echo $ln->urlBanner; ?></td>
                                    <td><img src="<?=base_url('/uploads/banner/' . $ln->imgBanner); ?>" class="img-responsive" width="200px" /></td>
                                    <td>
                                        <?php
                                            if($ln->statusBanner == 1){
                                                echo '<span class="text-primary">Ativa</span>';
                                            } else {
                                                echo '<span class="text-danger">Bloqueada</span>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo anchor('banner/editar/' . $ln->idBanner, '<i class="glyphicon glyphicon-edit"></i>', 'class="btn btn-info"'); ?>
                                        <?php echo anchor('banner/excluir/' . $ln->idBanner . '/' . $ln->imgBanner, '<i class="glyphicon glyphicon-trash"></i>', 'onclick="return confirm("Confirma exclusão do banner?")" class="btn btn-danger"'); ?>
                                    </td>
                                    <td><?php echo $ln->exibicaoBanner; ?></td>
                                    <td><?php echo $ln->cliqueBanner; ?></td>
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
<div class="modal fade" id="addBanner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php echo form_open_multipart('banner/add'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Adicionar Banner</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Legenda</label>
                    <input type="text" name="txtNome" class="form-control">
                </div>

                <div class="form-group">
                    <label>Imagem</label>
                    <input type="file" name="userfile" id="userfile" class="form-control" >
                </div>

                <div class="form-group">
                    <label>Url (link)</label>
                    <input type="url" name="txtUrl" class="form-control" placeholder="http://www.nomedominio.com.br">
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Ordem</label>
                            <input type="number" name="txtOrdem" class="form-control" >
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Posição</label>
                            <select name="slcPosicao" class="form-control">
                                <option value="1">Destaque Principal</option>
                                <option value="2">Destaque Secundário</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="slcStatus" class="form-control">
                                <option value="1">Publicado</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>
                    </div>
                </div>              

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <?php
                $atrBt = array("name" => "btn", "value" => "Cadastrar", "class" => "btn btn-default");
                echo form_submit($atrBt);
                ?>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    function ordemBanner(id, ordem) {

        $.ajax({
            type: "POST",
            data: {"id": id, "ordem": ordem},
            url: "<?php echo base_url("banner/editarordem") ?>",
            beforeSend: function () {
                $(".msg_retorno").html('<div class="alert alert-warning" role="alert">  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>   <span class="sr-only">Aguardando, salvando informação:</span> Erro </div>');
            },
            success: function (info) {
                $(".msg_retorno").html(info);
                window.location.reload();
            },
            error: function () {
                $(".msg_retorno").html('<div class="alert alert-danger" role="alert">  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>   <span class="sr-only">Error:</span> Erro </div>');
            }
        });
    }
</script>
