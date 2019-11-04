<?php
class Questoes extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");
        
        $this->load->model('Questoes_model', 'questoes');
    }
    
    public function index(){
        echo '<h1>Acesso Negado!</h1>';
    }
    
    // retorna total de questões repetidas do usuário
    public function getQuestoesRepetidas(){
        
        $data               = file_get_contents("php://input");
        $dataJsonDecode     = json_decode($data); 
        
        if($dataJsonDecode == null){
            $dataJson = array('status_conexao' => 0);
        }else{
            $lista = $this->questoes->getQtdeQuestoesRepetidasUsuario($dataJsonDecode->idUsuario);
            $total = $this->questoes->getQtdeTotalQuestoesUsuario($dataJsonDecode->idUsuario);
            $totalQuestoesRepetidas = 0;
            foreach($lista as $ls){
                if($ls->totalQuestoes > 1){
                    $totalQuestoesRepetidas++;
                }
            }
            
            $mediaRepeticao = ($totalQuestoesRepetidas * 100) / count($total);
            
            $dataJson = array(
                'totalQuestoesRepetidas' => $totalQuestoesRepetidas,
                'totalQuestoes' => count($total),
                'mediaRepeticao' => number_format($mediaRepeticao, 2, ',','.')
            );
        }
        
        echo json_encode($dataJson);
        
    }
    
    
    // retorna total de questões do usuário
    public function getQuestoesUsuario(){
        
        $data               = file_get_contents("php://input");
        $dataJsonDecode     = json_decode($data); 
        
        if($dataJsonDecode == null){
            echo '{ "dados": { "status_cadastro": "0" }}';
        }else{
            $lista = $this->questoes->getQtdeQuestoesUsuario($dataJsonDecode->idUsuario);

            echo '{ "dados": { "total_questoes": "'.count($lista).'" }}';
        }
        
    }
    
    
    
    
    
}