<?php
 /*
 * Model de Gerenciamento de Usuários
 * Autor: ARTE DESIGN PA 
 * Webite: www.artedesignpa com br
 */  
defined('BASEPATH') OR exit('No direct script access allowed');
class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->helper(array('form', 'url'));//autoload  
        $this->load->model('Usuarios_model', 'usuarios');
        //$this->load->library('form_validation', 'session','email');//autoload
    }

    public function index() {
        // se a sessao estiver ativa direciona a home
        if ($this->session->userdata('usuarioLogado') == true) {
            redirect('/home');
        } else {
            $this->session->sess_destroy();
            redirect('/account/login');
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


            if ($data = $this->usuarios->get_by_email($dados)) {//Se existe usuário entra e cria sessão
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
                $this->session->set_flashdata('error', 'Usuário ou senha incorretos, tente novamente! Caso não lembre de sua senha, clique no link <b>Esqueceu sua senha?</b>');
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
    public function cadastrar(){
        if ($this->session->userdata('usuarioLogado') == false) {//Se o usuário não estiver logado
            $this->load->view('/login/cadastrar_view');
        }else{
            $this->session->sess_destroy();
            redirect('/account/login');
        }
    }
    public function cadastroUsuario(){ 
        $this->form_validation->set_rules('txtUsuario', 'Usuário', 'trim|required|is_unique[usuarios.nomeUsuario]|min_length[5]|max_length[12]',array(
            'required' => '*O %s é obrigatório!',
            'is_unique' => '*Este %s já existe.',
            'min_length' => '*O %s tem que ter no mínimo 5 caracteres.',
            'max_length' => '*O %s tem que ter no máximo 12 caracteres.')
        );//mínimo de 5 e máximo de 12.
        $this->form_validation->set_rules('txtEmail', 'E-mail', 'trim|required|is_unique[usuarios.emailUsuario]|valid_email',array('is_unique'=>'*E-mail já cadastrado!'));
        $this->form_validation->set_rules('txtSenha', 'Senha','trim|required|min_length[6]',array(
            'required'      => '*A Senha é obrigatório!',
            'min_length' => '*A Senha tem que ter no mínimo 6 caracteres.')
        );//mínimo de 6 caracteres e igual ao campo senha
        $this->form_validation->set_rules('txtSenha2', 'Confirmação da Senha', 'required|matches[txtSenha]',array(
            'required'      => '*A confirmação da senha é obrigatório!',
            'matches' => '*A senha digitada não coincide com a anterior.')
        );
           
            if($this->form_validation->run() == TRUE){
                $dados = array(
                    'nomeUsuario'=> $this->input->post('txtUsuario'),
                    'nickName' => $this->input->post('txtUsuario'),
                    'emailUsuario' => $this->input->post('txtEmail'),
                    'senhaUsuario' => md5($this->input->post('txtSenha')),
                    'tipoUsuario' => '2',// 1 - Administrador e 2- usuário
                    'crmUsuario' => '',
                    'status' => '0' //Se 0 deixa desativado para posterior ativação via e-mail.
                    );
                    if($this->usuarios->adicionar($dados)){
                    /*Ao adicionar usuario, será enviado um e-mail o atual e-mail cadastrado
                    *Esse e-mail contém a url com o GET ou POST com o E-mail do usuário e se
                    *bater com o da página de ativação tornar ativo o usuário, ou seja , status = 1*/
                        $this->email($dados['emailUsuario']);
                        // configura mensagem sucesso
                        $this->session->set_flashdata('sucesso', 'Usuário cadastrado com sucesso!<br /> Um link de ativação foi enviado para sua conta de e-mail!');
                        redirect('/account/cadastrar');
                    }else{
                        // configura mensagem erro
                        $this->session->set_flashdata('error', 'Erro ao criar usuário!!!'.validation_errors());
                        redirect('/account/cadastrar');
                        }    
            }else{
            // configura mensagem de não validação do formulário
                $this->session->set_flashdata('error', 'Erro ao cadastrar usuário: <br />'.validation_errors());
                redirect('/account/cadastrar');
        }
    }
    //View Senha.
    public function senha(){
        $this->session->sess_destroy();
        $this->load->view('/login/recuperasenha_view');
    }
    public function recuperaSenha(){
            $this->load->helper('rand');
            $this->form_validation->set_rules('txtEmail', 'E-mail', 'trim|required|valid_email',
            array('required'=>'*E-mail não digitado corretamente!'));         
            if($this->form_validation->run() == TRUE){
                    $dados = array(
                        'emailUsuario' => $this->input->post('txtEmail'),
                        'senhaUsuario' => generateRandomString (8)//random_string($type='alnum', $len=8)
                    );
                        if($this->usuarios->senhaEmail($dados['emailUsuario'])){
                        //Se e-mail estiver cadastrado no banco, ele envia email e reseta senha.
                            $this->senhaEmail($dados['emailUsuario'],$dados['senhaUsuario']);//envia email
                        //Resultado com a senha criptografada
                            $resultado = array(
                                'emailUsuario' => $dados['emailUsuario'],
                                'senhaUsuario' => md5($dados['senhaUsuario'])
                            );
                            $this->reseta($resultado );//reseta senha
                            // configura mensagem sucesso
                            $this->session->set_flashdata('sucesso', 'Sucesso!<br /> Um e-mail com a nova senha foi enviado!');
                            redirect('/account/senha');
                        }else{
                            // configura mensagem erro
                            $this->session->set_flashdata('error', 'Erro ao recuperar a senha!<br /> Verique se o e-mail foi digitado corretamente.'.validation_errors());
                            redirect('/account/senha');
                            }    
                }else{
                // configura mensagem de não validação do formulário
                    $this->session->set_flashdata('error', 'Erro ao recuperar a senha: <br />'.validation_errors());
                    redirect('/account/senha');
            }
    }

    //envia e-mail
    public function email($emailUsuario){
        //$this->load->library('email');
        $urlAtivacao = base_url('/account/ativacao/?email=').$emailUsuario;//envia email via get
        $subject = 'Ativação de conta de usuário - QuizApp App';
        $message = '<p>Prezado,<br /> Clique no link baixo para ativar seu usuário:<br /></p>';
        // Get full html:
        $body = '<!DOCTYPE html>
        <head>
            <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="' . strtolower(config_item('charset')) . '" />
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <title>' . html_escape($subject) . '</title>
            <style type="text/css">
                body {
                    font-family: Arial, Verdana, Helvetica, sans-serif;
                    font-size: 16px;
                }
            </style>
        </head>
        <body>
        <p>' . $message . '</p>
        <a href="' . $urlAtivacao . '" target="_blank">ATIVAR CONTA</a>    
        </body>
        </html>';
        // Além disso, para obter o html completo, você pode usar o seguinte método interno:
        //$body = $this->email->full_html($subject, $message);
        $result = $this->email
            ->from('naoresponda@artedesignpa.com.br')
            ->reply_to('')    // Optional, an account where a human being reads.
            ->to($emailUsuario) //recebe o email cadastrado
            ->subject($subject)
            ->message($body)
            ->send();
       // var_dump($result);
        echo '<br />';
        //echo $this->email->print_debugger();
      //  exit;
    }
    //Recebe e-mail com a senha
    public function senhaEmail($emailUsuario, $senhaUsuario){
        //$this->load->library('email'); //Já iniciado no load
        $subject = 'Recupera senha do usuário - QuizApp App';
        $message = '<p>Prezado,<br />Segue dados para acesso a sua conta:<br /></p>';
        $body = '<!DOCTYPE html>
        <head>
            <meta http-equiv="X-UA-Compatible" content="IE=edge" charset="' . strtolower(config_item('charset')) . '" />
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <title>' . html_escape($subject) . '</title>
            <style>
            .jumbotron {
                padding: 0.1rem 0.1rem;
                margin-bottom: 0.1rem;
                background-color: #e9ecef;
                border-radius: .3rem;
            }
            .container {
                width: 100%;
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto;
            }
            .btn {
                display: inline-block;
                font-weight: 400;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                border: 1px solid transparent;
                padding: .375rem .75rem;
                font-size: 1rem;
                line-height: 1.5;
                border-radius: .25rem;
                transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            }
            .btn-primary{
                color: #fff;
                background-color: #0069d9;
                border-color: #0062cc; 
            }
            a {
                color: #fff;
                text-decoration: none;
                background-color: transparent;
                -webkit-text-decoration-skip: objects;
            }
            a:hover {
                color: #0056b3;
                text-decoration: underline;
            }
            .btn-primary:hover {
                color: #fff;
                background-color: #0069d9;
                border-color: #0062cc;
            }
            </style>
        </head>
        <body>
        <div class="jumbotron text-center">
        <h1><strong>Quiz</strong>App - App</h1>
        </div>
            <div class="container">
                <div class="row">
                <div class="col-sm-12">
                    <p>' . $message . '</p>
                    <p>E-mail: '. $emailUsuario.'</p>
                    <p>Nova Senha: '. $senhaUsuario.'</p>
                </div>
                </div>
            </div>
        <p><strong>Quiz</strong>App</p>  
        </body>
        </html>';//fim body
        $this->email
            ->from('naoresponda@localhost.com')
            //->reply_to('')    // Optional, an account where a human being reads.
            ->to($emailUsuario) //recebe o email
            ->subject($subject)
            ->message($body)
            ->send();
    }
    public function reseta($resultado){
            //print_r($dados);
            if(count($resultado)>0){//Se não estiver vazio
            /*     foreach ($resultado as $res);//copia de $resultado
                $resultado = array(//tem que passar como array novamente
                    'emailUsuario' => $res['emailUsuario'],
                    'senhaUsuario'=> $res['senhaUsuario']);//Atualiza senha do usuário */
                //print_r($resultado);
                if($this->usuarios->resetar($resultado)){
                    $msg = array("mensagem"=>"SENHA MODIFICADA!<br /> O e-mail: ".$resultado['emailUsuario']." foi confirmado!");
                    $this->load->view('/login/recuperasenha_view',$msg);
                }
              
            }else{
                $msg = array("mensagem"=>"SENHA NÃO MODIFICADA!<br />O e-mail $email não está cadastrado.");
                $this->load->view('/login/recuperasenha_view',$msg); 
        }
    }
    //Ativa Usuario após e-mail
    //$this->output->enable_profiler(TRUE); //debugar a pagina
    public function ativacao(){
        $email = $this->input->get('email');//recebe e-mail via GET.
        $resultado = $this->usuarios->ativacao($email);
            foreach ($resultado as $res);//copia de $resultado
            //print_r($res);
            if($resultado){
                $resultado = array(//tem que passar como array novamente
                    'emailUsuario' => $res['emailUsuario'],
                    'status'=> '1');//Ativa usuário
               // print_r($resultado);
                if($data = $this->usuarios->ativar($resultado)){
                    $msg = array("mensagem"=>"CONTA DE USUÁRIO ATIVADA!<br /> O e-mail: ".$resultado['emailUsuario']." foi confirmado!");
                    $this->load->view('/login/ativacao_view',$msg);
                   /*  var_dump($resultado);
                    var_dump($data); */
                }
              
            }else{
                $msg = array("mensagem"=>"CONTA DE USUÁRIO NÃO ATIVADA!<br />O e-mail $email não está cadastrado.");
                $this->load->view('/login/ativacao_view',$msg); 
        }
    }
}