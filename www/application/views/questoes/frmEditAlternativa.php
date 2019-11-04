
<!-- Modal -->
<div class="modal fade" id="editAlternativa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="width: 80%">
    <div class="modal-content">
        <form action="<?=base_url('/questoes/edita_alternativas'); ?>" method="post"> 
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Atualizar Alternativa</h4>
            </div>
            <div class="modal-body">
                  <div class="form-group">
                      <label>Enunciado da Alternativa*</label>
                      <textarea id="texto1" name="enunciado" class="form-control" required><?=$ln->enunciadoAlternativa?></textarea>
                      
                  </div>
                  <div class="form-group">
                      <label>Comentário da Alternativa</label>
                      <textarea id="texto2" name="comentario" class="form-control"><?=$ln->comentarioAlternativa?></textarea>
                      
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-info">Salvar</button>
              <input type="hidden" name="alternativa" value="<?=$ln->id_alternativas?>" />
              <input type="hidden" name="questao" value="<?=$ln->idquestoes?>" />
            </div>
        </form>
    </div>
  </div>
</div>