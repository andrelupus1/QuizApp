<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Model de Gerenciamento de Usuários
 * Autor: ARTE DESIGN PA 
 * Webite: www.artedesignpa com br
 */
class Provas_model extends CI_Model{
    // lista prova por id
    public function getProvaId($id, $usuario){
        $this->db->from('avaliacao av');
        $this->db->join('tipo_prova tp', 'tp.idtipo_prova = av.tipo_prova');
        $this->db->where('idavaliacao', $id);
        $this->db->where('idusuarios', $usuario);
        return $this->db->get()->row(0);
    }
    
    
    // adiciona prova
    public function addProva($ln = NULL){
        if($ln != NULL):
            $this->db->insert('avaliacao', $ln);
            return $this->db->insert_id();
        endif;
    }
    
    // atualiza avaliação
    public function updateAvaliacao($ln = array()){
        if(isset($ln['percAcerto'])):
            $this->db->set('percAcerto', $ln['percAcerto']);
        endif;
        if(isset($ln['qtdeQuestoes'])):
            $this->db->set('qtdeQuestoes', $ln['qtdeQuestoes']);
        endif;
        if(isset($ln['qtdeAcertos'])):
            $this->db->set('qtdeAcertos', $ln['qtdeAcertos']);
        endif;
        if(isset($ln['qtdeErros'])):
            $this->db->set('qtdeErros', $ln['qtdeErros']);
        endif;
        if(isset($ln['statusAvaliacao'])):
            $this->db->set('statusAvaliacao', $ln['statusAvaliacao']);
        endif;
        if(isset($ln['dataConclusao'])):
            $this->db->set('dataConclusao', $ln['dataConclusao']);
        endif;
        
        $this->db->where('idavaliacao', $ln['idavaliacao']);
        return $this->db->update('avaliacao');
    }
    
/*******************************************************************************
 * USUÁRIOS ESTATISTICAS
 ******************************************************************************/    
    // calcula média de acerto global para montagem do rancking
    public function getRanking(){
        /*$this->db->where('statusAvaliacao', '2');
        $this->db->group_by('idusuarios');
        return $this->db->get('avaliacao')->result();*/
        $query = $this->db->query("SELECT idusuarios, AVG(percAcerto) AS media FROM avaliacao WHERE statusAvaliacao = '2' GROUP BY idusuarios ORDER BY media DESC");
        return $query->result();
    }
    
    
    // cacula media de acerto global de um usuário
    public function getAcertoGlobalUsuario($idUser){
        $query = $this->db->query('SELECT AVG(percAcerto) AS media FROM avaliacao WHERE idUsuarios = "'.$idUser.'" AND statusAvaliacao = "2"');
        return $query->row(0);
    }
    
/*******************************************************************************
 * QUESTÕES
 ******************************************************************************/    
    // adiciona questões
    public function addQuestoes($ln = NULL){
        if($ln != NULL):
            $this->db->insert('questoes_respondidas', $ln);
            return $this->db->insert_id();
        endif;
    }
    
    // lista questões de uma prova
    public function getQuestoesAvaliacao($idAvaliacao){
        $this->db->where('avaliacao_id', $idAvaliacao);
        $this->db->order_by('idquestoes_respondidas', 'asc');
        return $this->db->get('questoes_respondidas')->result();
    }
    
    // lista questões por status
    public function getQuestoesResultado($idAvaliacao, $resultados){
        if($resultados == 'certas'):
            $query = $this->db->query("SELECT * FROM questoes_respondidas WHERE avaliacao_id = '".$idAvaliacao."' AND alternativaCorreta = alternativaSelecionada")->result();
        endif;
        if($resultados == 'erradas'):
            $query = $this->db->query("SELECT * FROM questoes_respondidas WHERE avaliacao_id = '".$idAvaliacao."' AND alternativaCorreta != alternativaSelecionada")->result();
        endif;
        return $query;
    }
    
    // atualiza dados da questão
    public function updateQuestao($ln = array()){
        if(isset($ln['alternativaCorreta'])):
            $this->db->set('alternativaCorreta', $ln['alternativaCorreta']);
        endif;
        if(isset($ln['alternativaSelecionada'])):
            $this->db->set('alternativaSelecionada', $ln['alternativaSelecionada']);
        endif;
        if(isset($ln['statusQuestao'])):
            $this->db->set('statusQuestao', $ln['statusQuestao']);
        endif;
        if(isset($ln['questaoFavorita'])):
            $this->db->set('questaoFavorita', $ln['questaoFavorita']);
        endif;
        
        $this->db->where('idquestoes_respondidas', $ln['idquestoes_respondidas']);
        return $this->db->update('questoes_respondidas');
    }
    
/*******************************************************************************
 * ALTERNATIVAS
 ******************************************************************************/    
    // lista alternativas de uma questão
    public function getAlternativasQuestao($questao){
        $this->db->where('idquestoes_respondidas', $questao);
        $this->db->order_by('idquestoes_alternativas', 'asc');
        return $this->db->get('questoes_respondidas_alternativas')->result();
    }
    
    // lista alternativa correta
    public function getAltCorreta($questao){
        $this->db->where('idquestoes_respondidas', $questao);
        $this->db->where('alternativaCorreta', '1');
        return $this->db->get('questoes_respondidas_alternativas')->row();
    }
    
    // adiciona alternativas
    public function addAlternativas($ln = NULL){
        if($ln != NULL):
            return $this->db->insert('questoes_respondidas_alternativas', $ln);
        endif;
    }
/*******************************************************************************
 * TIPOS DE PROVAS
 ******************************************************************************/
    // lista tipos de provas realizadas pelo usuario
    public function getTipoProvaUsuario($idUsuario, $tipoProva){
        $this->db->where('tipo_prova', $tipoProva);
        $this->db->where('idusuarios', $idUsuario);
        $this->db->where('statusAvaliacao', '2');
        return $this->db->get('avaliacao')->result();
        
    }
    // lista media de acertos nas provas
    public function getMediaTipoProvas($idUsuario){
        $query = $this->db->query("SELECT tipo_prova, SUM(percAcerto) as totalAcerto, tp.tipoProva FROM avaliacao av INNER JOIN tipo_prova tp ON tp.idtipo_prova = av.tipo_prova WHERE idusuarios = '".$idUsuario."' AND statusAvaliacao = '2' GROUP BY av.tipo_prova ORDER BY tp.tipoProva ASC;");
        return $query->result();
    }
/*******************************************************************************
 * DISCIPLINAS
 ******************************************************************************/ 
    // lista disciplina por questões resolvidas
    public function disciplinasQuestoesResolvidas($usuario){
        $this->db->select('disc.iddisciplinas, disc.nomeDisciplina');
        $this->db->from('questoes_matriz qm');
        $this->db->join('questoes_respondidas qr', 'qr.idquestoes_matriz = qm.idquestoes');
        $this->db->join('avaliacao av', 'av.idavaliacao = qr.avaliacao_id');
        $this->db->join('disciplinas disc', 'disc.iddisciplinas = qm.idDisciplina');
        $this->db->where('av.idusuarios', $usuario);
        $this->db->group_by('qm.idDisciplina');
        $this->db->order_by('disc.nomeDisciplina');
        return $this->db->get()->result();
    }
    
    // lista total de questões da disciplina entre certas, erradas e geral
    public function getTotalQuestoesDisciplinasResultado($idUsuario, $idDisciplina, $resultado = NULL){
        $this->db->select('qm.idDisciplina, qr.idquestoes_matriz, qr.alternativaCorreta, qr.alternativaSelecionada, av.idusuarios');
        $this->db->from('questoes_matriz qm');
        $this->db->join('questoes_respondidas qr', 'qr.idquestoes_matriz = qm.idquestoes');
        $this->db->join('avaliacao av', 'qr.avaliacao_id = av.idavaliacao');
        $this->db->where('av.idusuarios', $idUsuario);
        $this->db->where('av.statusAvaliacao', '2');
        $this->db->where('qm.idDisciplina', $idDisciplina);
        if($resultado == 'correta'){
            $this->db->where('qr.alternativaCorreta = qr.alternativaSelecionada');
        }
        return $this->db->get()->result();
    }
}