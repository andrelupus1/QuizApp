<?php
class Usuarios extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");
        $this->load->model('Usuarios_model', 'usuarios');
        $this->load->model('Provas_model', 'provas');
    }
    public function index(){
        echo '<h1>Acesso Negado!</h1>';
    } 
    // cadastra usuário
    public function addUsuario(){

        $data               = file_get_contents("php://input");//pega todos os Dados
        $dataJsonDecode     = json_decode($data); 
        
        if($dataJsonDecode == null){
            echo '{ "dados": { "status_cadastro": "0" }}';//se não receber nada
            /*  $dados = array ( //teste url direto
                'emailUsuario' => 'teste@teste.com'
            );
            $this->email($dados['emailUsuario']);  */
        }else{
            $dados = array(
                'nomeUsuario'=> $dataJsonDecode->nome,
                'emailUsuario' => $dataJsonDecode->email,
                'nickName' => $dataJsonDecode->nick,
                'senhaUsuario' => md5($dataJsonDecode->senha),
                'crmUsuario' => $dataJsonDecode->crm,
                'tipoUsuario' => '2',//tipo 2 é usuário
                'status' => '0'//cadastra com estatus desativado para ativar via e-mail.
            );
            //Se não exitir executa código 1A
            if ($data = $this->usuarios->getEmail($dados)){
               if($data['emailUsuario']===$dados['emailUsuario']){
                echo '{ "dados": { "status_cadastro": "0" }}';
                }
            }else{//Código 1A: adionar e envia email
                if($this->usuarios->adicionar($dados)){
                    // configura mensagem
                    $this->email($dados['emailUsuario']);
                    echo '{ "dados": { "status_cadastro": "1" }}';
                }else{
                    // configura mensagem
                    echo '{ "dados": { "status_cadastro": "0" }}';
                }
            }
        }
    }
    //Atualizar usuário
    public function upUsuario(){

        $data               = file_get_contents("php://input");
        $dataJsonDecode     = json_decode($data); 
        
        if($dataJsonDecode == null){
            echo '{ "dados": { "status_cadastro": "0" }}';
        }else{
            // verifica se a senha foi atualizada
            if($dataJsonDecode->senha != NULL){
                $dados = array(
                    'id_usuario'=> $dataJsonDecode->id,
                    'nome_usuario'=> $dataJsonDecode->nome,
                    'email_usuario' => $dataJsonDecode->email,
                    'nickName' => $dataJsonDecode->nick,
                    'senha_usuario' => md5($dataJsonDecode->senha),
                    'crm_usuario' => $dataJsonDecode->crm                
                );
            }else{
                $dados = array(
                    'id_usuario'=> $dataJsonDecode->id,
                    'nome_usuario'=> $dataJsonDecode->nome,
                    'email_usuario' => $dataJsonDecode->email,
                    'nickName' => $dataJsonDecode->nick,
                    'crm_usuario' => $dataJsonDecode->crm                
                );
            }
            

            if($this->usuarios->atualizar($dados)){
                // configura mensagem
                 echo '{ "dados": { "status_cadastro": "1" }}';
            }else{
                // configura mensagem
                 echo '{ "dados": { "status_cadastro": "0" }}';
            }

        }

    }
    public function login(){
        $data               = file_get_contents("php://input");
        $dataJsonDecode     = json_decode($data); 
        
        
        //var_dump($dataJsonDecode);
        if($dataJsonDecode == null){
            $jSonUser = '{ "dados": { "status_cadastro": "0" }}';
        }else{
            $dados = array(
                'usuario' => $dataJsonDecode->email,
                'senha' => md5($dataJsonDecode->senha)
            );

            //var_dump($dados);

            if ($data = $this->usuarios->get_by_email($dados)) {
                
                $crm = @explode("-", $data->crmUsuario);
                
                $jSonUser  = '{
                            "dados": {
                                "usuario_id": "'.$data->idusuarios.'",
                                "usuario_nome": "'.$data->nomeUsuario.'",
                                "usuario_email": "'.$data->emailUsuario.'",
                                "usuario_crmuf": "'.$crm[0].'",
                                "usuario_crm": "'.$crm[1].'",
                                "loginUsuario": true,
                                "status": "1"
                            }
                        }';
            }else{
                // configura mensagem
                 $jSonUser = '{ "dados": { "status": "0" }}';
            }
        }
        //header("Access-Control-Allow-Origin: *");
        //header("Content-Type: application/json; charset=UTF-8");
        echo $jSonUser;
    }
    // calcula acerto global do usuario com base nas avaliações finalizadas
    public function getAcertoGlobal(){
        $data               = file_get_contents("php://input");
        $dataJsonDecode     = json_decode($data); 
        
        
        //var_dump($dataJsonDecode);
        if($dataJsonDecode == null){
            $jSonUser = '{ "dados": { "status_cadastro": "0" }}';
        }else{
            $usuario = $dataJsonDecode->idUsuario;
            
            $media = $this->provas->getAcertoGlobalUsuario($usuario);
            
            $jSonUser  = '{
                            "dados": {
                                "usuario_id": "'.$usuario.'",
                                "mediaGlobal": "'.number_format($media->media, 2, ',', '.').'"                                
                            }
                        }';
        }
        
        echo $jSonUser;
    }   
    // verifica posição no ranking
    public function getPosicaoRanking(){
        
        $data               = file_get_contents("php://input");
        $dataJsonDecode     = json_decode($data); 
        
        //var_dump($dataJsonDecode);
        if($dataJsonDecode == null){
            $jSonUser = '{ "dados": { "status_cadastro": "0" }}';
        }else{
            $usuario = $dataJsonDecode->idUsuario;
            // resgata alternativa correta
            $lista = $this->provas->getRanking();
            $i = 1;
            foreach($lista as $ls){
                if($ls->idusuarios == $usuario){
                    $posicao = $i;
                }
                $i++;
            }
            
            $dados = array(
                'posicao' => $posicao,
                'totalUsuarios' => count($lista)
            );
            
            echo json_encode($dados);
        }
    }
     //envia e-mail
     public function email($emailUsuario){
        //$this->load->library('email');
        $urlAtivacao = base_url('/account/ativacao/?email=').$emailUsuario;//envia email via get
        $subject = 'Ativação de conta de usuário - OftQuiz App';
        $message = '<p>Prezado,<br /> Clique no link baixo para ativar seu usuário:<br /></p>';
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
        <h1><strong>Oft</strong>Quiz - App</h1>
        </div>
            <div class="container">
                <div class="row">
                <div class="col-sm-12">
                    <p>' . $message . '</p>
                    <a href="' . $urlAtivacao . '" class="btn btn-primary active" role="button" aria-pressed="true">ATIVAR CONTA</a>
                </div>
                </div>
            </div>
        <p><strong>Oft</strong>Quiz</p>  
        </body>
        </html>';//fim body
        $result = $this->email
            ->from('naoresponda@oftquiz.com.br')
            ->reply_to('')    // Optional, an account where a human being reads.
            ->to($emailUsuario) //recebe o email cadastrado
            ->subject($subject)
            ->message($body)
            ->send();
    }
}