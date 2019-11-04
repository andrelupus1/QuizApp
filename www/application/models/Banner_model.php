<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 /*
 * Model de Gerenciamento de Usuários
 * Autor: ARTE DESIGN PA 
 * Webite: www.artedesignpa com br
 */  
class Banner_model extends CI_Model {
    public function listatodas(){            
        $this->db->from('banners');        
        $this->db->order_by('ordemBanner', 'ASC');                
        return $this->db->get()->result();
    }
    
    // lista banner por posição
    public function getBannerPosicao($posicao){
        //$this->db->where('posicaoBanner', $posicao);
        $this->db->where('statusBanner', '1');
        $this->db->order_by('ordemBanner', 'ASC');                
        return $this->db->get('banners')->result();
    }      
    
    /*public function lista_banner_rand($tipo){
        $this->db->select('*');
        $this->db->from('banners');
        $this->db->where('tipoBanner', $tipo);
        $this->db->where('statusBanner', '1');
        $this->db->order_by('rand()');                
        $this->db->limit(1);
        return $this->db->get()->row(0);
    }*/
    
    public function lista_por_id($id){
        $this->db->where('idBanner', $id);
        $query = $this->db->get('banners');
        return $query->row(0);
    }
    
    public function adicionar($dados = NULL){
        if($dados != NULL){
            return $this->db->insert('banners', $dados);           
        }
    }
    
    public function atualiza($options = array()){
        
        if(isset($options['ordemBanner'])){
            $this->db->set('ordemBanner', $options['ordemBanner']);            
        }
        
        if(isset($options['nomeBanner'])){
            $this->db->set('nomeBanner', $options['nomeBanner']);            
        }
        
        if(isset($options['urlBanner'])){
            $this->db->set('urlBanner', $options['urlBanner']);            
        }
        
        if(isset($options['legendaBanner'])){
            $this->db->set('legendaBanner', $options['legendaBanner']);
        }
                
        if(isset($options['posicaoBanner'])){
            $this->db->set('posicaoBanner', $options['posicaoBanner']);
        }
        
        if(isset($options['statusBanner'])){
            $this->db->set('statusBanner', $options['statusBanner']);
        }
        if(isset($options['cliqueBanner'])){
            $this->db->set('cliqueBanner', $options['cliqueBanner']);
        }
        
        if(isset($options['exibicaoBanner'])){
            $this->db->set('exibicaoBanner', $options['exibicaoBanner']);
        }
        
        $this->db->where('idBanner', $options['idBanner']);
        return $this->db->update('banners');
               
    }
    
    public function atualiza_img($options = array()){
        
        if(isset($options['imgBanner'])){
            $this->db->set('imgBanner', $options['imgBanner']);
        }
        
        $this->db->where('idBanner', $options['idBanner']);
        $this->db->update('banners');
        
        return $this->db->affected_rows();
    }
    
    public function excluir(){
        $this->db->where('idBanner', $this->uri->segment(3));
        $this->db->delete('banners');
        return $this->db->affected_rows();
    }
    public function todosBanner(){
        $this->db->where('statusBanner',1);
        $this->db->order_by('ordemBanner', 'asc');
        return $query = $this->db->get('banners')->result_array();
        //return $query->row(0);
    }
    public function indice($acao=NULL, $valor=NULL){
        if($acao==0){//CONSULTA| SELECT
            $query = $this->db->query("SELECT indice FROM banners_indice;");
            return $query->result_array();
            //return $query = $this->db->get('banners_indice')->result();      
        }
        if($acao==1){//ADD | PUSH
            //$this->db->insert('banners_indice', $valor);
            $this->db->set('indice', $valor);
            $this->db->insert('banners_indice');       
        }
        if($acao==2){// REMOVE | POP
            
            $this->db->empty_table('banners_indice');//limpa tabela          
        }
    }
 }