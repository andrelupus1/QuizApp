<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Model de Gerenciamento de Usuários
 * Autor: ARTE DESIGN PA 
 * Webite: www.artedesignpa com br
 */
class Questoes_model extends CI_Model{
    
    public function getQuestoes(){
        $this->db->order_by('anoQuestao', 'asc');
        return $this->db->get('questoes_matriz')->result();
    }
    
    // lista questao por id
    public function getQuestaoId($id){
        $this->db->where('idquestoes', $id);
        return $this->db->get('questoes_matriz')->row(0);
    }
    
    // busca questão para avaliação
    public function getGeraQuestaoAvaliacao($disciplina = NULL, $tipoProva = NULL, $limite){
        if($disciplina != NULL):
            $this->db->where('idDisciplina', $disciplina);
        endif;
        if($tipoProva != NULL):
            $this->db->where('idtipo_prova', $tipoProva);
        endif;
        $this->db->limit($limite);
        $this->db->order_by('rand()');
        return $this->db->get('questoes_matriz')->result();
    }
    
    // adiciona questão
    public function add_questao($ln = null){
        if($ln != null):
            $this->db->insert('questoes_matriz', $ln);
            return $this->db->insert_id();
        endif;
    }
    
    // atualiza questao
    public function edita_questao($ln = array()){
        if(isset($ln['idDisciplina'])):
            $this->db->set('idDisciplina', $ln['idDisciplina']);
        endif;
        if(isset($ln['idTema'])):
            $this->db->set('idTema', $ln['idTema']);
        endif;
        if(isset($ln['idsubtemas'])):
            $this->db->set('idsubtemas', $ln['idsubtemas']);
        endif;
        if(isset($ln['idtipo_prova'])):
            $this->db->set('idtipo_prova', $ln['idtipo_prova']);
        endif;
        if(isset($ln['anoQuestao'])):
            $this->db->set('anoQuestao', $ln['anoQuestao']);
        endif;
        if(isset($ln['numQuestao'])):
            $this->db->set('numQuestao', $ln['numQuestao']);
        endif;
        if(isset($ln['enunciadoQuestao'])):
            $this->db->set('enunciadoQuestao', $ln['enunciadoQuestao']);
        endif;
        if(isset($ln['alternativaCorreta'])):
            $this->db->set('alternativaCorreta', $ln['alternativaCorreta']);
        endif;
        if(isset($ln['comentarioQuestao'])):
            $this->db->set('comentarioQuestao', $ln['comentarioQuestao']);
        endif;
        if(isset($ln['imgQuestao'])):
            $this->db->set('imgQuestao', $ln['imgQuestao']);
        endif;
        if(isset($ln['statusQuestao'])):
            $this->db->set('statusQuestao', $ln['statusQuestao']);
        endif;
        
        $this->db->where('idquestoes', $ln['idquestao']);
        return $this->db->update('questoes_matriz');
    }
    
    // deleta questão
    public function del_questao($id){
        // deleta alternativas
        $this->db->where('idquestoes', $id);
        $this->db->delete('questoes_matriz_alternativas');
        
        // deleta questao
        $this->db->where('idquestoes', $id);
        return $this->db->delete('questoes_matriz');
    }
    
/*******************************************************************************
 * ALTERNATIVAS
 ******************************************************************************/    
    public function getAlternativas($questao){
        $this->db->where('idquestoes', $questao);
        $this->db->order_by('id_alternativas', 'asc');
        return $this->db->get('questoes_matriz_alternativas')->result();
    }
    // seleciona alternativa por id
    public function getAlternativasId($id){
        $this->db->where('id_alternativas', $id);
        return $this->db->get('questoes_matriz_alternativas')->row(0);
    }
    // adiciona alternativa
    public function add_alternativa($ln = null){
        if($ln != null):
            return $this->db->insert('questoes_matriz_alternativas', $ln);
        endif;  
    }
    // atualiza alternativa
    public function edita_alternativa($ln = array()){
        if(isset($ln['enunciado'])):
            $this->db->set('enunciadoAlternativa', $ln['enunciado']);
        endif;
        if(isset($ln['comentario'])):
            $this->db->set('comentarioAlternativa', $ln['comentario']);
        endif;
        if(isset($ln['alternativaCorreta'])):
            // zera as alternativas corretas
            $this->db->set('alternativaCorreta', 0);
            $this->db->where('idquestoes', $ln['idquestoes']);
            $this->db->update('questoes_matriz_alternativas');
            
            $this->db->set('alternativaCorreta', $ln['alternativaCorreta']);
        endif;
        
        $this->db->where('id_alternativas', $ln['idalternativa']);
        return $this->db->update('questoes_matriz_alternativas');
    }
    // deleta alternativa
    public function del_alternativa($id){
        $this->db->where('id_alternativas', $id);
        return $this->db->delete('questoes_matriz_alternativas');
    }
/*******************************************************************************
 * TEMAS E SUBTEMAS
 ******************************************************************************/    
    public function getTemas(){
        $this->db->order_by('nomeTema', 'asc');
        return $this->db->get('temas')->result();
    }
    
    // lista tema por id
    public function getTemaId($id){
        $this->db->where('idtema', $id);
        return $this->db->get('temas')->row(0);
    }
    
    public function getTemaDisciplinas($id){
        $this->db->where('iddisciplinas', $id);
        $this->db->order_by('nomeTema', 'asc');
        return $this->db->get('temas')->result();
    }
    
    // adiciona tipo de registro
    public function add_tema($ln = null){
        if($ln != null){
            return $this->db->insert('temas', $ln);
        }
    }
    
    // atualiza tipo de registro
    public function atualiza_tema($ln = array()){
        if(isset($ln['disciplina'])){
            $this->db->set('iddisciplinas', $ln['disciplina']);
        }
        if(isset($ln['nome'])){
            $this->db->set('nomeTema', $ln['nome']);
        }
        
        $this->db->where('idtema', $ln['id']);
        return $this->db->update('temas');
    }
    
    // deleta registro
    public function excluir_tema($id){
        $this->db->where('idtema', $id);
        $this->db->delete('subtemas');
        
        $this->db->where('idtema', $id);
        return $this->db->delete('temas');
    }
    
    /*** SUBTEMAS ***/
    public function getSubtemas($tema){
        $this->db->where('idtema', $tema);
        $this->db->order_by('nomeSubtema', 'asc');
        return $this->db->get('subtemas')->result();
    }
    
    // lista subtema por id
    public function getSubtemaId($id){
        $this->db->where('idsubtemas', $id);
        return $this->db->get('subtemas')->row(0);
    }
    
    public function add_subtema($ln = null){
        if($ln != null):
            return $this->db->insert('subtemas', $ln);
        endif;
    }
    
    public function up_subtema($ln = array()){
        if(isset($ln['idtema'])){
            $this->db->set('idtema', $ln['idtema']);
        }
        if(isset($ln['nomesubtema'])){
            $this->db->set('nomeSubtema', $ln['nomesubtema']);
        }
        
        $this->db->where('idsubtemas', $ln['id']);
        return $this->db->update('subtemas');
    }
    
    public function del_subtema($id){
        $this->db->where('idsubtemas', $id);
        return $this->db->delete('subtemas');
    }
/*******************************************************************************
 * TIPOS DE REGISTROS
 ******************************************************************************/    
    public function getTipoProva(){
        $this->db->order_by('tipoProva', 'asc');
        return $this->db->get('tipo_prova')->result();
    }
    
    // lista tipo de prova por id
    public function getTipoProvaID($id){
        $this->db->where('idtipo_prova', $id);
        return $this->db->get('tipo_prova')->row(0);
    }
    
    // adiciona tipo de registro
    public function add_tipo($ln = null){
        if($ln != null){
            return $this->db->insert('tipo_prova', $ln);
        }
    }
    
    // atualiza tipo de registro
    public function atualiza_tipo($ln = array()){
        if(isset($ln['tipoProva'])){
            $this->db->set('tipoProva', $ln['tipoProva']);
        }
        
        $this->db->where('idtipo_prova', $ln['idtipo']);
        return $this->db->update('tipo_prova');
    }
    
    // deleta registro
    public function excluir_tipo($id){
        $this->db->where('idtipo_prova', $id);
        return $this->db->delete('tipo_prova');
    }
/*******************************************************************************
 * DISCIPLINAS
 ******************************************************************************/    
    public function getDisciplinas(){
        $this->db->order_by('nomeDisciplina', 'asc');
        return $this->db->get('disciplinas')->result();
    }
    
    // lista termos por busca por de disciplinas
    public function getDisciplinasTermos($termo){
        $this->db->from('disciplinas disc');
        $this->db->join('temas tm', 'tm.iddisciplinas = disc.iddisciplinas');
        $this->db->like('nomeDisciplina', $termo);
        $this->db->order_by('tm.nomeTema', 'asc');
        return $this->db->get()->result();
    }


    // lista apenas disciplinas que possuem questões vinculadas
    public function getDisciplinasQuestoes(){
        $this->db->from('disciplinas disc');
        $this->db->join('questoes_matriz qm', 'qm.idDisciplina = disc.iddisciplinas');
        $this->db->order_by('nomeDisciplina', 'asc');
        $this->db->group_by('disc.iddisciplinas');
        return $this->db->get()->result();
    }
    
    public function getDisciplinaID($id){
        $this->db->where('iddisciplinas', $id);
        return $this->db->get('disciplinas')->row();
    }
    
    // adiciona tipo de registro
    public function add_disciplina($ln = null){
        if($ln != null){
            return $this->db->insert('disciplinas', $ln);
        }
    }
    
    // atualiza tipo de registro
    public function atualiza_disciplina($ln = array()){
        if(isset($ln['nomeDisciplina'])){
            $this->db->set('nomeDisciplina', $ln['nomeDisciplina']);
        }
        
        $this->db->where('iddisciplinas', $ln['id']);
        return $this->db->update('disciplinas');
    }
    
    // deleta registro
    public function excluir_disciplina($id){
        $this->db->where('iddisciplinas', $id);
        return $this->db->delete('disciplinas');
    }
    
/*******************************************************************************    
 * PROVAS E QUESTÕES RESPONDIDAS
 ******************************************************************************/    
    // lista provas/avaliações
    public function getProvas($idUsuario){
        $this->db->from('avaliacao av');
        $this->db->join('tipo_prova tp', 'tp.idtipo_prova = av.tipo_prova');
        $this->db->where('av.idusuarios', $idUsuario);
        $this->db->order_by('av.statusAvaliacao', 'asc');
        $this->db->order_by('av.dataCadastro', 'desc');
        return $this->db->get()->result();
    }
    
    
    // listas questões respondidas por um determinado usuário
    public function getQtdeTotalQuestoesUsuario($usuario){
        $this->db->from('avaliacao av');
        $this->db->join('questoes_respondidas qr', 'qr.avaliacao_id = av.idavaliacao');
        $this->db->where('av.idusuarios', $usuario);
        $this->db->order_by('qr.idquestoes_respondidas', 'asc');
        return $this->db->get()->result();
    }
    
    // listas questões respondidas por um determinado usuário
    public function getQtdeQuestoesUsuario($usuario){
        $this->db->from('avaliacao av');
        $this->db->join('questoes_respondidas qr', 'qr.avaliacao_id = av.idavaliacao');
        $this->db->where('av.idusuarios', $usuario);
        $this->db->where('qr.statusQuestao', '1');
        $this->db->order_by('qr.idquestoes_respondidas', 'asc');
        return $this->db->get()->result();
    }
    
    // listas questões respondidas e repetidas por um determinado usuário
    public function getQtdeQuestoesRepetidasUsuario($usuario){
        $this->db->select('av.idusuarios, qr.idquestoes_matriz, COUNT(qr.idquestoes_matriz) AS totalQuestoes');
        $this->db->from('questoes_respondidas qr');
        $this->db->join('avaliacao av', 'av.idavaliacao = qr.avaliacao_id');
        $this->db->where('av.idusuarios', $usuario);
        $this->db->group_by('qr.idquestoes_matriz');
        $this->db->order_by('totalQuestoes', 'desc');
        return $this->db->get()->result();
    }
    
}