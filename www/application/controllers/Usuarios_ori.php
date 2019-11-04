<?php if (!defined("BASEPATH")) exit ("Você não pode carregar esta página diretamante.");
class Usuarios extends CI_Controller{

    public function __construct() {
        parent::__construct();
        
        $this->load->model('Usuarios_model', 'usuarios');

        if ($this->session->userdata('usuarioLogado') == false) {
            redirect('/home');
        }
    }

    // lista todos eventos
    public function index(){

        $dados = array(
            'idadmin' => $this->session->userdata('id'),
            'admin' => $this->usuarios->getUsuarios(1),
        );
        
        $this->load->view('/templates/header_html');
        $this->load->view('/templates/header');
        $this->load->view('/templates/sidebar');
        $this->load->view('/usuarios/index_usuarios', $dados);
        $this->load->view('/templates/footer');
        $this->load->view('/templates/footer_html');

    }
   
    // lista todos eventos
    public function add(){

        $this->form_validation->set_rules('txtNome', 'NOME', 'trim|required|max_length[50]|ucwords');
        $this->form_validation->set_rules('txtEmail', 'E-MAIL', 'trim|required|strtolower|valid_email');

        if($this->form_validation->run() == TRUE){

            $dados = array(
                'nomeUsuario'=> $this->input->post('txtNome'),
                'emailUsuario' => $this->input->post('txtEmail'),
                'senhaUsuario' => md5($this->input->post('txtSenha')),
                'tipoUsuario' => '1',
                'status' => '1'
            );

            if($this->usuarios->adicionar($dados)){
                // configura mensagem
                $this->session->set_flashdata('sucesso', 'Usuário cadastrado com sucesso!!!');
                redirect('/usuarios');
            }else{
                // configura mensagem
                $this->session->set_flashdata('error', 'Erro ao criar usuário!!!');
                redirect("/usuarios/");
            }
        }else{
            // configura mensagem
                $this->session->set_flashdata('error', 'Erro ao criar usuário!!!');
                redirect("/usuarios/");
        }

    }

    // lista todos eventos
    public function editar(){

        $this->form_validation->set_rules('txtNome', 'NOME', 'trim|required|ucwords');
        $this->form_validation->set_rules('txtEmail', 'E-MAIL', 'trim|required|strtolower|valid_email');

        if($this->form_validation->run() == TRUE){
            if($this->input->post('txtSenha')!==""){
              $dados = array(
                  'id_usuario' => $this->input->post('administrador'),
                  'nome_usuario'=> $this->input->post('txtNome'),
                  'email_usuario' => $this->input->post('txtEmail'),
                  'senha_usuario' => md5($this->input->post('txtSenha'))
              );
            }else{
               $dados = array(
                 'id_usuario' => $this->input->post('administrador'),
                 'nome_usuario'=> $this->input->post('txtNome'),
                 'email_usuario' => $this->input->post('txtEmail'),
               );
            }

            if($this->usuarios->atualizar($dados)){
                // configura mensagem
                $this->session->set_flashdata('sucesso', 'Usuário editado com sucesso!!!');
                redirect('/usuarios/editar/'.$this->input->post('administrador'));
            }else{
                // configura mensagem
                $this->session->set_flashdata('error', 'Erro ao editar usuário!!!');
                redirect('/usuarios/editar/'.$this->input->post('administrador'));
            }
        }else{

            $idAdmin = $this->uri->segment(3);

            $dados = array(
                'admin' => $this->usuarios->getUsuarioId($idAdmin)
            );
            
            $this->load->view('/templates/header_html');
            $this->load->view('/templates/header');
            $this->load->view('/templates/sidebar');
            $this->load->view('/usuarios/editar', $dados);
            $this->load->view('/templates/footer');
            $this->load->view('/templates/footer_html');
        }

    }

    public function excluir(){
        if($this->usuarios->excluir($this->uri->segment(3))){
            $this->session->set_flashdata("sucesso", "Usuário deletado com sucesso!!");
            redirect('/usuarios/');
        }
    }
    
/*******************************************************************************
 * USUÁRIOS APLICATIVO
 ******************************************************************************/    
    
    // lista todos eventos
    public function app(){

        $dados = array(
            'idadmin' => $this->session->userdata('id'),
            'admin' => $this->usuarios->getUsuarios(2),
        );
        
        $this->load->view('/templates/header_html');
        $this->load->view('/templates/header');
        $this->load->view('/templates/sidebar');
        $this->load->view('/usuarios/usuarios_app', $dados);
        $this->load->view('/templates/footer');
        $this->load->view('/templates/footer_html');

    }

    

}
