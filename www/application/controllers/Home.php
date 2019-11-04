<?php
/*
 * Class de Gerenciamento da Home do sistema
 * Autor: Diego Sampaio - RDCODE - diego.estaleiro@gmail.com
 * 
 */
class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuarios_model', 'usuarios');
    }

    public function index() {
        if ($this->session->userdata('usuarioLogado') == true) {
            
            $this->load->view('/templates/header_html');
            $this->load->view('/templates/header');
            $this->load->view('/templates/sidebar');
            $this->load->view('/home/index_home');
            $this->load->view('/templates/footer');
            $this->load->view('/templates/footer_html');
        } else {
            redirect('/account/login');
        }
    }

}
