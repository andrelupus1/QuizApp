<?php
/*
 * Model de Gerenciamento de Usuários
 * Autor: Diego Sampaio - RDCODE - diego.estaleiro@gmail.com
 *
 */
class Usuarios_model extends CI_Model{
    // lista todos os usuários
    public function getUsuarios($tipo){
        $this->db->where('tipoUsuario', $tipo);
        $this->db->order_by('nomeUsuario', 'asc');
        return $this->db->get('usuarios')->result();
    }
    // lista usuário por id
    public function getUsuarioId($id) {
        $this->db->where('idusuarios', $id);
        return $this->db->get('usuarios')->row(0);
    }
    // consulta dados para login
    public function get_by_email($dados){
        // consulta sql - por enquanto isso não se faz tem que ser na model
        $this->db->from('usuarios');
        $this->db->where('emailUsuario', $dados['usuario']);
        $this->db->where('senhaUsuario', $dados['senha']);
        $this->db->where('status', 1);
        $query = $this->db->get();

        if($query->num_rows() == 1){
            return $query->row();
        }else{
            return false;
        }
    }
    // adiciona usuario
    public function adicionar($ln = NULL){
        if($ln != NULL):
            return $this->db->insert('usuarios', $ln);
        endif;
    }
    // atualiza dados do usuário
    public function atualizar($ln = array()){

        if(isset($ln['nome_usuario'])):
            $this->db->set('nomeUsuario', $ln['nome_usuario']);
        endif;
        if(isset($ln['email_usuario'])):
            $this->db->set('emailUsuario', $ln['email_usuario']);
        endif;
        if(isset($ln['nickName'])):
            $this->db->set('nickName', $ln['nickName']);
        endif;
        if(isset($ln['senha_usuario'])):
            $this->db->set('senhaUsuario', $ln['senha_usuario']);
        endif;
        if(isset($ln['crm_usuario'])):
            $this->db->set('crmUsuario', $ln['crm_usuario']);
        endif;
        if(isset($ln['status_usuario'])):
            $this->db->set('status', $ln['status_usuario']);
        endif;

        $this->db->where('idusuarios', $ln['id_usuario']);
        return $this->db->update('usuarios');
    }
    // excluir usuário
    public function excluir($id){
        
        // exclui os logs de acesso
        $this->db->where('idusuarios', $id);
        $this->db->delete('usuarios_logs');
        
        $this->db->where('idusuarios', $id);
        return $this->db->delete('usuarios');
    }
}
