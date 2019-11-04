<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuarios_model', 'usuarios');
        $this->load->library('form_validation');
    }

    public function index() {
        // se a sessao estiver ativa direciona a home
        if ($this->session->userdata('usuarioLogado') == true) {
            redirect('/home');
        } else {
            $this->load->view('/account');
        }
    }

    public function login() {
        $this->form_validation->set_rules('usuario', 'Usuario', 'trim|required');
        $this->form_validation->set_rules('senha', 'Senha', 'trim|required');

        if ($this->form_validation->run() == true) {
            $dados = array(
                'usuario' => $this->input->post('usuario'),
                'senha' => md5($this->input->post('senha'))
            );


            if ($data = $this->usuarios->get_by_email($dados)) {
                $sessao = array(
                    'id' => $data->idusuarios,
                    'nome_usuario' => $data->nomeUsuario,  
                    'email_usuario' => $data->emailUsuario,
                    'tipo_usuario' => $data->tipoUsuario,
                    'usuarioLogado' => true
                );

                $this->session->set_userdata($sessao);
                redirect('/home');
            }else {
                $this->session->set_flashdata('error', 'Usuário ou senha incorretos, tente novamente! Caso não lembre de sua senha, clique no link <b>Esqueceu dua senha?</b>');
                redirect('/account/login');
            }
        } else {
            $this->load->view('/login/login_view');
        }
    }
    
    public function logout() {
        $this->session->sess_destroy();
        redirect('/account/login');
    }

}
