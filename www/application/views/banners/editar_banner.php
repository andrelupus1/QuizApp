<!-- Paginas -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Banners
            <small>Banners cadastrados no site</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('/home'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
           <li><a href="<?= base_url('/banner'); ?>"> Banners</a></li>
            <li class="active">Editar Banner</li>
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
                                    <h4>Atenção!</h4>
                                    ' . $this->session->flashdata('sucesso') . '
                                </div>';
                    }
                    if ($this->session->flashdata('erro')) {
                        echo '<div class="alert alert-danger" style="margin: 20px">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <h4>Atenção!</h4>
                                    ' . $this->session->flashdata('erro') . '
                                </div>';
                    }
                ?>
                <div class="table-responsive">                                
                    <?php echo form_open_multipart('banner/editar/' . $banner->idBanner); ?>
                    <?php
                    if (validation_errors() == true) {
                        echo '<div class="alert alert-danger"> ' . validation_errors() . ' </div>';
                    }
                    ?>                                                                                                            

                    <div class="form-group">
                        <label>Titulo</label>
                        <input type="text" name="txtNome" class="form-control" value="<?php echo $banner->nomeBanner; ?>">                                            
                    </div>

                    <div class="form-group">
                        <label>Imagem do Banner</label>
                        <br />
                        <?php
                        if (empty($banner->imgBanner)) {
                            echo "<pre>Imagem não cadastrada</pre>";
                            $nomeBt = "Cadastrar imagem";
                        } else {
                            echo '<img src="'.base_url('/uploads/banner/' . $banner->imgBanner).'" class="img-responsive" />';
                            $nomeBt = "Alterar imagem";
                        }
                        ?>
                        <!-- Button trigger modal -->                                        
                        <a href="javascript:void()" title="<?php echo $nomeBt; ?>" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formLogo"><?php echo $nomeBt; ?></a>
                    </div>

                    <div class="form-group">
                        <label>Url (link)</label>
                        <input type="url" name="txtUrl" class="form-control" placeholder="http://dominio.com.br" value="<?php echo $banner->urlBanner; ?>">                                            
                    </div>
                    
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Ordem</label>
                                <input type="number" name="txtOrdem" class="form-control" value="<?php echo $banner->ordemBanner; ?>" >
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Posição</label>
                                <select name="slcPosicao" class="form-control">
                                    <option value="1" <?=($banner->posicaoBanner == 1) ? 'selected' : ''; ?>>Destaque Principal</option>
                                    <option value="2" <?=($banner->posicaoBanner == 2) ? 'selected' : ''; ?>>Destaque Secundário</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="slcStatus" class="form-control">
                                    <option value="1" <?=($banner->statusBanner == 1) ? 'selected' : ''; ?>>Publicado</option>
                                    <option value="0" <?=($banner->statusBanner == 0) ? 'selected' : ''; ?>>Inativo</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <?php echo anchor('/banner/', 'Voltar', 'class="label label-default"'); ?>
                        <input type="submit" name="btEnvia" class="btn btn-primary" value="Salvar dados" />
                        <input type="hidden" name="banner" value="<?php echo $banner->idBanner; ?>" />
                    </div> 
                    </form>
                </div>

            </div><!--.box-body-->
        </div><!--.box-->
    </section>
</div><!--.content-wrapper-->



<!-- Modal -->
<div class="modal fade" id="formLogo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <?php echo form_open_multipart('banner/atualizaimg'); ?>    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $nomeBt; ?></h4>
            </div>
            <div class="modal-body">
                <?php
                echo '<span class="validacao"> ' . validation_errors() . ' </span>';

                echo form_fieldset();

                echo form_label("Imagem", "userfile");
                echo '<input type="file" name="userfile" id="userfile" class="form-control" />';

                echo form_fieldset_close();
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>        
                <?php
                $atrBt = array("name" => "btn", "value" => "Salvar imagem", "class" => "btn btn-default");
                echo form_submit($atrBt);
                ?>

                <input type="hidden" name="imgAntiga" value="<?php echo $banner->imgBanner; ?>" />
                <input type="hidden" name="banner" value="<?php echo $banner->idBanner; ?>" />
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>    
</div>