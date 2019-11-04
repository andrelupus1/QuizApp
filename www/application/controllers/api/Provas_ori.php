<?php
class Provas extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");
        
        $this->load->model('Questoes_model', 'questoes');
        $this->load->model('Provas_model', 'provas');
        $this->load->model('Usuarios_model', 'usuarios');
    }
    
    public function index(){
        echo '<h1>Acesso Negado!</h1>';
    }
    
    public function getProvas(){
        
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        
        $data               = file_get_contents("php://input");
        $dataJsonDecode     = json_decode($data); 
        
        if($dataJsonDecode == null){
            echo '{ "dados": { "status_conexao": "0" }}';
        }else{
            $lista = $this->questoes->getProvas($dataJsonDecode->idUsuario);
            if(count($lista) > 0){
                $jSonInst = '{ "dados":[';
                    foreach ($lista as $ln):

                        $jSonInst .= '{ ';
                        $jSonInst .= '"idavaliacao": "'.$ln->idavaliacao.'",';
                        $jSonInst .= '"idusuario": "'.$ln->idusuarios.'",';
                        $jSonInst .= '"tipoProva": "'.$ln->tipoProva.'",';
                        $jSonInst .= '"qtde_acerto": "'.$ln->qtdeAcertos.'",';
                        $jSonInst .= '"qtde_erro": "'.$ln->qtdeErros.'",';
                        $jSonInst .= '"perc_acerto": "'.$ln->percAcerto.'",';
                        $jSonInst .= '"status": "'.$ln->statusAvaliacao.'",';
                        $jSonInst .= '"dataRealizacao": "'.dataHora_BR($ln->dataCadastro).'"';                        
                        $jSonInst .= '},';
                    endforeach;
                    $jSonInst = substr($jSonInst, 0, -1);
                $jSonInst .= ']}';

            }else{
                $jSonInst = '{ "dados": { "status_conexao": "0" } }';
            }

            echo $jSonInst;
        }
    }
    
    
    // gera prova
    public function geraProva(){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        
        $data               = file_get_contents("php://input");
        $dataJsonDecode     = json_decode($data); 
        
        if($dataJsonDecode == null){
            echo '{ "dados": { "status_conexao": "0" }}';
        }else{
            $idUsuario    = $dataJsonDecode->idUser; // tipo de prova
            $tipo         = $dataJsonDecode->tipoProva; // tipo de prova
            $qtde         = $dataJsonDecode->qtdeQuestoes; // qtde de questões
            $disciplinas  = $dataJsonDecode->disciplinas; // qtde de questões
            $list_questao = array();
            // se for fornecida apenas uma disciplina, o sistema busca todos
            if(count($disciplinas) == 1){
                //echo "Uma Disciplina: \n";
                $list_questao = $this->questoes->getGeraQuestaoAvaliacao($disciplinas[0], $tipo, $qtde);
                //var_dump($list_questao);
                //echo '=====================================================';
            }else{
                //echo "Várias Disciplinas e Qtde: ".$qtde[0]." \n";
                for($i=1; $i<=$qtde[0]; $i++){
                    
                    // verifica se a disciplina é zerada ou não
                    if(count($disciplinas) == 0){
                        $idDisciplina = NULL;
                    }else{
                        // se for fornecida mais de uma disciplina, o sistema sorteia aleatoriamente uma disciplina
                        $key_disc = array_rand($disciplinas); // sorteia uma disciplina
                        $idDisciplina = $disciplinas[$key_disc];
                    }
                    //echo "Questão num.: ".$i." Disciplina: ".$idDisciplina." Tipo de Prova: ".$tipo." - Usuario: ".$idUsuario." \n";
                    // monta array com as questões selecionadas            
                    $slc_questao = $this->questoes->getGeraQuestaoAvaliacao($idDisciplina, $tipo, 1);
                    //var_dump($slc_questao);
                    
                    // verifica se o array já existe
                    if(!in_array($slc_questao, $list_questao)){
                        array_push($list_questao, $slc_questao);
                        //echo "\n [ADICIONADO] \n";
                    }else{                        
                        $i--;
                       // echo "\n [REPETIDO] \n";
                    }
                    //echo "\n ===================================================== \n";
                }
                
            }
            
            //$quest_selecionadas = 
            //echo "QUESTÕES SELECIONADAS \n";
            //var_dump($list_questao);
            
            
            //echo "\n ================================================== \n";
            //echo "Questões a serem Inseridas: \n";
            // insere questões e alternativas nas avaliações
            if(count($list_questao) > 0){
                
                // cria nova avaliação
                $dd_av = array(
                    'tipo_prova' => $tipo,
                    'idusuarios' => $idUsuario,
                    'qtdeQuestoes' => $qtde[0],
                    'statusAvaliacao' => 0
                ); 
                $idAvaliacao = $this->provas->addProva($dd_av);
            
                
                //echo " - Qtde de questões: ".count($list_questao);
                //echo "\n";
                $x=1;
                foreach($list_questao as $lq){
                    //echo "NUM.: ".$x."\n";
                    //var_dump($lq[0]);
                    if(count($lq) > 0){
                        // monta array com questão
                        $ln_quest = array(
                            'idquestoes_matriz' => $lq[0]->idquestoes,
                            'enunciadoQuestao' => $lq[0]->enunciadoQuestao,
                            'avaliacao_id' => $idAvaliacao,
                            'comentarioQuestao' => $lq[0]->comentarioQuestao,
                            'imgQuestao' => $lq[0]->imgQuestao,
                            'statusQuestao' => 0
                        );
                        //var_dump($ln_quest);
                        $idQuestao = $this->provas->addQuestoes($ln_quest);
                        $x++;
                        
                        //echo "ADD=>".$idQuestao;
                    
                        // lista as alternativas matriz para inserção na tabela de alternativas respostas
                        $alternativas = $this->questoes->getAlternativas($lq[0]->idquestoes);
                        if(count($alternativas) > 0){
                            foreach($alternativas as $alt){
                                $ln_alt = array(
                                    'idalternativa_matriz' => $alt->id_alternativas,
                                    'idquestoes_respondidas' => $idQuestao,
                                    'enunciadoAlternativa' => $alt->enunciadoAlternativa,
                                    'alternativaCorreta' => $alt->alternativaCorreta
                                );
                                $this->provas->addAlternativas($ln_alt);
                            }
                        }
                    }                    
                }
                
                echo '{ "dados": { "idAvaliacao": "'.$idAvaliacao.'", "status_conexao": "1" }}';
                
            }else{
                echo '{ "dados": { "status_conexao": "2" }}';
            }
            
        }
    }
    
    // lista prova por id
    public function getProvaId(){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        
        $data               = file_get_contents("php://input");
        $dataJsonDecode     = json_decode($data); 
        
        if($dataJsonDecode == null){
            echo '{ "dados": { "status_conexao": "0" }}';
        }else{
            $idUsuario    = $dataJsonDecode->idUser; 
            $idProva      = $dataJsonDecode->idProva; 
            
            $prova = $this->provas->getProvaId($idProva, $idUsuario);
            $questoes = $this->provas->getQuestoesAvaliacao($idProva);
            // lista questões da avaliação
            if(count($questoes) > 0){
                $list_questao = array();
                $i = 1;
                foreach($questoes as $quest){
                    
                    // lista alternativas da questão
                    $alternativa = $this->provas->getAlternativasQuestao($quest->idquestoes_respondidas);
                    $list_alternativas = array();
                    if(count($alternativa) > 0){
                        $i2 = 1;
                        foreach($alternativa as $alt){
                            /*
                            $list_alternativas  .= '{'
                                                . '"idAlternativa": "'.$alt->idquestoes_alternativas.'",'
                                                . '"ordemAlternativa": "'.$i2.'",'
                                                . '"enunciadoAlternativa": "'.strip_tags(trim(addslashes($alt->enunciadoAlternativa), "n")).'",'
                                                . '"altCorreta": "'.$alt->alternativaCorreta.'"'
                                                . '},';
                             * */
                             $list_alt = array(
                                 'idAlternativa' => $alt->idquestoes_alternativas,
                                 'ordemAlternativa' => $i2,
                                 'enunciadoAlternativa' => html_entity_decode(strip_tags($alt->enunciadoAlternativa)),
                                 'altCorreta' => $alt->alternativaCorreta
                             );
                            $i2++;
                            
                            array_push($list_alternativas, $list_alt);
                        }
                        //$list_alternativas = substr($list_alternativas, 0, -1);
                        //json_encode($list_alternativas);
                    }
                    
                    $favorita = ($quest->questaoFavorita == 1) ? 'true' : 'false';
                    // . '"comentarioQuest": "'.html_entity_decode($quest->comentarioQuestao).'",'
                    /*
                    $list_quest .= '{ '
                                . '"idQuestao": "'.$quest->idquestoes_respondidas.'",'
                                . '"ordemQuestao": "'.$i.'",'
                                . '"avaliacao_id": "'.$quest->avaliacao_id.'",'
                                . '"enunciado": "'.strip_tags(trim(addslashes($quest->enunciadoQuestao), "n")).'",'
                                . '"altCorreta": "'.$quest->alternativaCorreta.'",'
                                . '"altSelecionada": "'.$quest->alternativaSelecionada.'",'
                                . '"statusQuest": "'.$quest->statusQuestao.'",'                                
                                . '"favorita": "'.$favorita.'",'
                                . '"alternativas": ['.$list_alternativas.']'
                            . ' },';                   
                     */
                    if($quest->imgQuestao != ""){
                        $imgDestaque = base_url('/uploads/questoes/'.$quest->imgQuestao); 
                    }else{
                        $imgDestaque = NULL;
                    }
                    
                    $list_quest = array(
                        'idQuestao' => $quest->idquestoes_respondidas,
                        'ordemQuestao' => $i,
                        'avaliacao_id' => $quest->avaliacao_id,
                        'enunciado' => html_entity_decode(strip_tags($quest->enunciadoQuestao)), 
                        'img' => $imgDestaque, 
                        'comentario' => html_entity_decode(strip_tags($quest->comentarioQuestao)),
                        'altCorreta' => $quest->alternativaCorreta,
                        'altSelecionada' => $quest->alternativaSelecionada,
                        'statusQuest' => $quest->statusQuestao,
                        'favorita' => $favorita,
                        'alternativas' => $list_alternativas
                    );
                    $i++;
                    array_push($list_questao, $list_quest);
                }
                //$list_quest = substr($list_quest, 0, -1);
                //json_decode($list_quest);
                
            }
            
            if(count($prova) == 1){
                $dadosAvaliacao = array(
                            'usuario' => $idUsuario,
                            'avaliacao' => $idProva,
                            'tipoProva' => $prova->tipoProva,
                            'percAcerto' => $prova->percAcerto,
                            'qtdeQuestoes' => $prova->qtdeQuestoes,
                            'qtdeAcertos' => $prova->qtdeAcertos,
                            'qtdeErros' => $prova->qtdeErros,
                            'statusProva' => $prova->statusAvaliacao,
                            'dataAbertura' => dataHora_BR($prova->dataCadastro),
                            'dataConclusao' => dataHora_BR($prova->dataConclusao)
                        );
                
                $jsonDados = array(                        
                        'avaliacao' => $idProva,
                        'dados_avaliacao' => array($dadosAvaliacao),
                        'questoes' => $list_questao
                    );
                /*
                echo '{ "dados": { '
                            . '"usuario": "'.$idUsuario.'", '
                            . '"avaliacao": "'.$idProva.'", '
                            . '"dados_avaliacao": [{'
                            .    '"avaliacao": "'.$idProva.'", '
                            .    '"tipoProva": "'.$prova->tipoProva.'", ' 
                            .    '"percAcerto": "'.$prova->percAcerto.'", ' 
                            .    '"qtdeQuestoes": "'.$prova->qtdeQuestoes.'", ' 
                            .    '"qtdeAcertos": "'.$prova->qtdeAcertos.'", ' 
                            .    '"qtdeErros": "'.$prova->qtdeErros.'", ' 
                            .    '"statusProva": "'.$prova->statusAvaliacao.'", ' 
                            .    '"dataAbertura": "'.dataHora_BR($prova->dataCadastro).'", ' 
                            .    '"dataConclusao": "'.dataHora_BR($prova->dataConclusao).'" ' 
                            . '}],'
                            . '"questoes": ['.$list_quest.']'
                        . '}'
                    . '}';
                 * 
                 */
            }else{
                /*
                echo '{ "dados": { '
                            . '"usuario": "'.$idUsuario.'", '
                            . '"avaliacao": "'.$idProva.'" '
                        . '}'
                    . '}';
                 * 
                 */
                $jsonDados = array(
                    'usuario' => $idUsuario,
                    'avaliacao' => $idProva
                );
            }
            
            echo json_encode($jsonDados, JSON_UNESCAPED_UNICODE);
            
        }
    }
    
    // salva resposta correta
    public function getResposta(){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        
        $data               = file_get_contents("php://input");
        $dataJsonDecode     = json_decode($data); 
        
        if($dataJsonDecode == null){
            echo '{ "dados": { "status_conexao": "0" }}';
        }else{
            $idAvaliacao = $dataJsonDecode->idAvaliacao; 
            $idQuestao = $dataJsonDecode->idQuestao; 
            $idAlt     = $dataJsonDecode->idAlt; 
            
            // resgata alternativa correta
            $correta = $this->provas->getAltCorreta($idQuestao);
            
            //var_dump($correta);
            
            $dados  = array(
                'idquestoes_respondidas' => $idQuestao,
                'alternativaCorreta' => $correta->idquestoes_alternativas,
                'alternativaSelecionada' => $idAlt,
                'statusQuestao' => '1'
            );
            
            if($this->provas->updateQuestao($dados)){
                
                // atualiza dados da avaliação
                // tais como: qtdeQuestoes, Status
                // qtde de questões
                $quest = $this->provas->getQuestoesAvaliacao($idAvaliacao);
                // qtde de questões corretas
                $questCorretas = $this->provas->getQuestoesResultado($idAvaliacao, 'certas');
                // qtde de questões erradas
                $questErros = $this->provas->getQuestoesResultado($idAvaliacao, 'erradas');
                
                $perc_acertos = (count($questCorretas) * 100) / count($quest);
                
                // verifica status da avaliação
                $qtdeQuestoes = count($quest);
                $qtdeResolvidas = count($questCorretas) + count($questErros);
                if($qtdeQuestoes == $qtdeResolvidas){
                    $statusAv = 2;
                    $dataConclusao = date('Y-m-d H:i:s');
                }else{
                    $statusAv = 1;
                    $dataConclusao = NULL;
                }
                
                $ddAv = array(
                    'idavaliacao' => $idAvaliacao,
                    'percAcerto' => number_format($perc_acertos, 2, ',','.'),
                    'qtdeQuestoes' => count($quest),
                    'qtdeAcertos' => count($questCorretas),
                    'qtdeErros' => count($questErros),
                    'statusAvaliacao' => $statusAv,
                    'dataConclusao' => $dataConclusao
                );
                
                //var_dump($ddAv);
                
                $this->provas->updateAvaliacao($ddAv);
                
                echo '{ "dados": { '
                            . '"questao": "'.$idQuestao.'", '
                            . '"alternativa": "'.$idAlt.'", '                            
                            . '"percAcerto": "'.$perc_acertos.'", '
                            . '"qtdeAcertos": "'.count($questCorretas).'", '
                            . '"qtdeErros": "'.count($questErros).'", '
                            . '"statusAvaliacao":"'.$statusAv.'", '
                            . '"dataConclusão":"'.$dataConclusao.'", '
                            . '"status_conexao": "1" '
                        . '}}';
            }else{
                echo '{ "dados": { "status_conexao": "0" }}';
            }            
        }
    }
    // salva questão como favorita
    public function getFavorita(){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        
        $data               = file_get_contents("php://input");
        $dataJsonDecode     = json_decode($data); 
        
        if($dataJsonDecode == null){
            echo '{ "dados": { "status_conexao": "0" }}';
        }else{
            $idQuestao = $dataJsonDecode->idQuestao; 
            $status    = $dataJsonDecode->status; 
            
            // resgata alternativa correta
            $correta = $this->provas->getAltCorreta($idQuestao);
            
            //var_dump($correta);
            
            $dados  = array(
                'idquestoes_respondidas' => $idQuestao,
                'questaoFavorita' => $status
            );
            
            if($this->provas->updateQuestao($dados)){
                echo '{ "dados": { "questao": "'.$idQuestao.'", "status_conexao": "1" }}';
            }else{
                echo '{ "dados": { "status_conexao": "0" }}';
            }            
        }
    }
    
    // ranking
    public function getRanking(){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        
            // resgata alternativa correta
            $lista = $this->provas->getRanking();
            
            if(count($lista) == 0){
                echo '{ "dados": { "qtdeUsuarios": "0" }}';
            }else{
                $list_users = '';
                $i = 1;
                $list_users = '';
                foreach($lista as $ls){
                    //$media = $this->provas->getAcertoGlobalUsuario($ls->idusuarios);
                    $usuario = $this->usuarios->getUsuarioId($ls->idusuarios);
                    
                        $list_users  .= '{'
                                    . '"posicao": "'.$i.'",'                                    
                                    . '"idUsuario": "'.$ls->idusuarios.'",'                                    
                                    . '"nickName": "'.$usuario->nickName.'",'
                                    . '"nomeUsuario": "'.$usuario->nomeUsuario.'",'
                                    . '"mediaAcerto": "'.number_format($ls->media, 2,',','.').'"'
                                . '},';        
                        $i++;
                    
                }
                $list_users = substr($list_users, 0, -1);                
                
                echo '{ "dados": {'
                        . '"qtdeUsuarios": "'.count($lista).'",'
                        . '"usuarios": ['. $list_users .' ]'
                        . '}}';
        }
    }
    
    // lista disciplinas associadas a questões resolvidas
    public function getDisciplinasQuestoes(){
        $data               = file_get_contents("php://input");
        $dataJsonDecode     = json_decode($data); 
        
        $lista = $this->provas->disciplinasQuestoesResolvidas($dataJsonDecode->idUsuario);
        
        if(count($lista) == 0){
            $dataJson = array('status_cadastro' => 0);
        }else{
            $dataJson = array();
            foreach($lista as $ls){
                
                // busca total de questões da disciplina
                $total = $this->provas->getTotalQuestoesDisciplinasResultado($dataJsonDecode->idUsuario, $ls->iddisciplinas, NULL);
                $corretas = $this->provas->getTotalQuestoesDisciplinasResultado($dataJsonDecode->idUsuario, $ls->iddisciplinas, 'correta');
                
                $mediaAcerto = (count($corretas) * 100) / count($total);
                
                $ln = array(
                        'disciplina' => $ls->nomeDisciplina,
                        'qtdeQuestoes' => count($total),
                        'qtdeCorretas' => count($corretas),
                        'mediaAcerto' => number_format($mediaAcerto, 2,',','.')
                    );
                
                array_push($dataJson, $ln);
            }            
        }
        
        echo json_encode($dataJson);
    }
    
    private function rBlankLines($str) {  
        $str = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $str);  
        return $str;
    }
    
/*******************************************************************************
 * TIPOS DE PROVAS
 ******************************************************************************/
    public function getTipoProva(){
        
        $lista = $this->questoes->getTipoProva();
        
        
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        if(count($lista) > 0){
            $jSonInst = '{ "dados":[';
                foreach ($lista as $ln):
                    
                    $jSonInst .= '{ ';
                    $jSonInst .= '"id_tipo": "'.$ln->idtipo_prova.'",';
                    $jSonInst .= '"tipo": "'.$ln->tipoProva.'"';
                    $jSonInst .= '},';
                endforeach;
                $jSonInst = substr($jSonInst, 0, -1);
            $jSonInst .= ']}';

        }else{
            $jSonInst = '{ "dados": { "status_conexao": "0" } }';
        }

        echo $jSonInst;

    }
    
    // lista media de tipo de provas do usuário
    public function getMediaTipoProva(){
        $data               = file_get_contents("php://input");
        $dataJsonDecode     = json_decode($data); 
        
        $lista = $this->provas->getMediaTipoProvas($dataJsonDecode->idUsuario);
        
        if(count($lista) == 0){
            $dataJson = array('status_cadastro' => 0);
        }else{
            $dataJson = array();
            foreach($lista as $ln){
                // verifica qtde total de avaliações do tipo de prova
                $total = $this->provas->getTipoProvaUsuario($dataJsonDecode->idUsuario, $ln->tipo_prova);
                $media = $ln->totalAcerto / count($total);
                $ls = array(
                    'tipoProva' => $ln->tipoProva,
                    'totalAcerto' => $ln->totalAcerto,
                    'totalOcorrencias' => count($total),
                    'mediaAcerto' => number_format($media, 2, ',','.')
                );
                
                array_push($dataJson, $ls);
            }
        }
        
        echo json_encode($dataJson);
    }
/*******************************************************************************
 * TEMAS E SUBTEMAS
 ******************************************************************************/
    public function getTemas(){ 
        
        $lista = $this->questoes->getTemas();
        
        
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        if(count($lista) > 0){
            $jSonInst = '{ "dados":[';
                foreach ($lista as $ln):
                    
                    $jSonInst .= '{ ';
                    $jSonInst .= '"id_tema": "'.$ln->idtema.'",';
                    $jSonInst .= '"disciplina": "'.$ln->iddisciplinas.'",';
                    $jSonInst .= '"tema": "'.$ln->nomeTema.'"';
                    $jSonInst .= '},';
                endforeach;
                $jSonInst = substr($jSonInst, 0, -1);
            $jSonInst .= ']}';

        }else{
            $jSonInst = '{ "dados": { "status_conexao": "0" } }';
        }

        echo $jSonInst;

    }
    
/*******************************************************************************
 * DISCIPLINAS
 ******************************************************************************/
    public function getDisciplinas(){
        
        $lista = $this->questoes->getDisciplinasQuestoes();
        
        
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        if(count($lista) > 0){
            $jSonInst = '{ "dados":[';
                foreach ($lista as $ln):
                    
                    $jSonInst .= '{ ';
                    $jSonInst .= '"id_disciplina": "'.$ln->iddisciplinas.'",';
                    $jSonInst .= '"disciplina": "'.$ln->nomeDisciplina.'",';
                    $jSonInst .= '"checked": "false"';
                    $jSonInst .= '},';
                endforeach;
                $jSonInst = substr($jSonInst, 0, -1);
            $jSonInst .= ']}';

        }else{
            $jSonInst = '{ "dados": { "status_conexao": "0" } }';
        }

        echo $jSonInst;

    }    
    
}