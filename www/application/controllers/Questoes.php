<?php
class Questoes extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
        if($this->session->userdata('usuarioLogado') == false){
            redirect('/account/login');
        }
        $this->load->helper('ckeditor');
        $this->load->model('Questoes_model', 'questoes');
    }
    
    public function index(){
        $dados = array(
            'lista' => $this->questoes->getQuestoes()
        );
        
        $this->load->view('/templates/header_html');
        $this->load->view('/templates/header');
        $this->load->view('/templates/sidebar');
        $this->load->view('/questoes/index_questoes', $dados);
        $this->load->view('/templates/footer');
        $this->load->view('/templates/footer_html');
    }
    
    public function add(){
        $this->form_validation->set_rules('tipoprova', 'TIPO DE PROVA', 'trim|required');
        $this->form_validation->set_rules('disciplina', 'DISCIPLINA', 'trim|required');
        $this->form_validation->set_rules('tema', 'TEMA', 'trim|required');
        $this->form_validation->set_rules('ano', 'ANO', 'trim|required');
        $this->form_validation->set_rules('enunciado', 'ENUNCIADO DA QUESTÃO', 'trim|required');

        if($this->form_validation->run() == TRUE){
            
            // faz upload
            $config['upload_path'] = 'uploads/questoes/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            //$config['max_size'] = '2048';
            //$config['max_width'] = '800';
            //$config['max_height'] = '600'; 
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);

            $this->upload->do_upload();
            $arquivo_upado = $this->upload->data();
        
            $dados = array(
                    'idDisciplina' => $this->input->post('disciplina'),
                    'idTema' => $this->input->post('tema'),
                    'idsubtemas' => $this->input->post('subtema'),
                    'idtipo_prova' => $this->input->post('tipoprova'),
                    'anoQuestao' => $this->input->post('ano'),
                    'numQuestao' => $this->input->post('numero'),
                    'enunciadoQuestao' => $this->input->post('enunciado'),
                    'comentarioQuestao' => $this->input->post('comentario'),
                    'imgQuestao' => $arquivo_upado['file_name'],
                    'statusQuestao' => 1
                );
            
            if($id = $this->questoes->add_questao($dados)){
                $this->session->set_flashdata('sucesso', 'Questão cadastrada com sucesso, adicione abaixo as respectivas alternativas!');
                redirect('/questoes/alternativas/'.$id);
            }else{
                $this->session->set_flashdata('error', 'Erro ao adicionar Registro!');
                redirect('/questoes/add');
            }
            
        }else{
            $dados = array(
                'disciplina' => $this->questoes->getDisciplinas(),
                'temas' => $this->questoes->getTemas(),
                'tipoProva' => $this->questoes->getTipoProva(),
                'ckeditor_texto' => array(
                    'id' => 'texto1', //id da textarea a ser substituída pelo CKEditor
                    'path' => 'layout/admin/js/ckeditor', // caminho da pasta do CKEditor relativo a pasta raiz do CodeIgniter
                    'config' => array(// configurações opcionais
                        'toolbar' => "Basic",
                        'width' => "100%",
                        'height' => "400px",
                    )
                ),
                'ckeditor_texto2' => array(
                    'id' => 'texto2', //id da textarea a ser substituída pelo CKEditor
                    'path' => 'layout/admin/js/ckeditor', // caminho da pasta do CKEditor relativo a pasta raiz do CodeIgniter
                    'config' => array(// configurações opcionais
                        'toolbar' => "Basic",
                        'width' => "100%",
                        'height' => "250px",
                    )
                )
            );

            $this->load->view('/templates/header_html');
            $this->load->view('/templates/header');
            $this->load->view('/templates/sidebar');
            $this->load->view('/questoes/add_questao', $dados);
            $this->load->view('/templates/footer');
            $this->load->view('/templates/footer_html');
        }
    }
    public function editar(){
        $this->form_validation->set_rules('tipoprova', 'TIPO DE PROVA', 'trim|required');
        $this->form_validation->set_rules('disciplina', 'DISCIPLINA', 'trim|required');
        $this->form_validation->set_rules('tema', 'TEMA', 'trim|required');
        $this->form_validation->set_rules('subtema', 'SUBTEMA', 'trim|required');
        $this->form_validation->set_rules('ano', 'ANO', 'trim|required');
        $this->form_validation->set_rules('enunciado', 'ENUNCIADO DA QUESTÃO', 'trim|required');

        if($this->form_validation->run() == TRUE){
        
            $dados = array(
                    'idquestao' => $this->input->post('questao'),
                    'idDisciplina' => $this->input->post('disciplina'),
                    'idTema' => $this->input->post('tema'),
                    'idsubtemas' => $this->input->post('subtema'),
                    'idtipo_prova' => $this->input->post('tipoprova'),
                    'anoQuestao' => $this->input->post('ano'),
                    'numQuestao' => $this->input->post('numero'),
                    'enunciadoQuestao' => $this->input->post('enunciado'),
                    'comentarioQuestao' => $this->input->post('comentario'),
                    'statusQuestao' => $this->input->post('status')
                );
            
            if($id = $this->questoes->edita_questao($dados)){
                $this->session->set_flashdata('sucesso', 'Questão cadastrada com sucesso, adicione abaixo as respectivas alternativas!');
                redirect('/questoes/editar/'.$this->input->post('questao'));
            }else{
                $this->session->set_flashdata('error', 'Erro ao adicionar Registro!');
                redirect('/questoes/editar/'.$this->input->post('questao'));
            }
            
        }else{
            $idQuestao = $this->uri->segment(3);
            $ln = $this->questoes->getQuestaoId($idQuestao);
            $dados = array(
                'questao' => $this->questoes->getQuestaoId($idQuestao),
                
                'disciplina' => $this->questoes->getDisciplinas(),
                'temas' => $this->questoes->getTemaDisciplinas($ln->idDisciplina),
                'subtemas' => $this->questoes->getSubtemas($ln->idTema),
                'tipoProva' => $this->questoes->getTipoProva(),
                'ckeditor_texto' => array(
                    'id' => 'texto1', //id da textarea a ser substituída pelo CKEditor
                    'path' => 'layout/admin/js/ckeditor', // caminho da pasta do CKEditor relativo a pasta raiz do CodeIgniter
                    'config' => array(// configurações opcionais
                        'toolbar' => "Basic",
                        'width' => "100%",
                        'height' => "400px",
                    )
                ),
                'ckeditor_texto2' => array(
                    'id' => 'texto2', //id da textarea a ser substituída pelo CKEditor
                    'path' => 'layout/admin/js/ckeditor', // caminho da pasta do CKEditor relativo a pasta raiz do CodeIgniter
                    'config' => array(// configurações opcionais
                        'toolbar' => "Basic",
                        'width' => "100%",
                        'height' => "250px",
                    )
                )
            );

            $this->load->view('/templates/header_html');
            $this->load->view('/templates/header');
            $this->load->view('/templates/sidebar');
            $this->load->view('/questoes/editar_questao', $dados);
            $this->load->view('/templates/footer');
            $this->load->view('/templates/footer_html');
        }
    }
    
    public function editarImagem(){
        // faz upload
        $config['upload_path'] = 'uploads/questoes/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        //$config['max_size'] = '2048';
        //$config['max_width'] = '800';
        //$config['max_height'] = '600'; 
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);

        $this->upload->do_upload();
        $arquivo_upado = $this->upload->data();

        $dados = array(
            'idquestao' => $this->input->post('questao'),
            'imgQuestao' => $arquivo_upado['file_name']
        );
        if($this->questoes->edita_questao($dados)){
            // configura mensagem
            $this->session->set_flashdata('sucesso', 'Imagem atualizada com sucesso!!!');
            redirect('/questoes/editar/'.$this->input->post('questao'));
        }else{
            // configura mensagem
            $this->session->set_flashdata('error', 'Erro ao atualizar Imagem!!!');
            redirect('/questoes/editar/'.$this->input->post('questao'));
        }
    }
    public function delImagem(){
        $dados = array(
            'idquestao' => $this->uri->segment(3),
            'imgQuestao' => ''
        );
        if($this->questoes->edita_questao($dados)){
            // configura mensagem
            $this->session->set_flashdata('sucesso', 'Imagem deletada com sucesso!!!');
            redirect('/questoes/editar/'.$this->uri->segment(3));
        }else{
            // configura mensagem
            $this->session->set_flashdata('error', 'Erro ao deletar Imagem!!!');
            redirect('/questoes/editar/'.$this->uri->segment(3));
        }
    }
    
    // deleta questao
    public function del_questao(){
        if($this->questoes->del_questao($this->input->post('questao'))){
            $this->session->set_flashdata('sucesso', 'Registro deletado com sucesso!');
            redirect('/questoes/');
        }else{
            $this->session->set_flashdata('error', 'Erro ao deletar registro!');
            redirect('/questoes/');
        }
    }
    
    
    // adiciona e manipula alternativas
    public function alternativas(){
        $this->form_validation->set_rules('enunciado', 'ENUNCIADO DA ALTERNATIVA', 'trim|required');

        if($this->form_validation->run() == TRUE){
        
            $dados = array(
                    'idquestoes' => $this->input->post('questao'),
                    'enunciadoAlternativa' => $this->input->post('enunciado'),
                    'comentarioAlternativa' => $this->input->post('comentario')
                );
            
            if($this->questoes->add_alternativa($dados)){
                $this->session->set_flashdata('sucesso', 'Alternativa cadastrada com sucesso!');
                redirect('/questoes/alternativas/'.$this->input->post('questao'));
            }else{
                $this->session->set_flashdata('error', 'Erro ao adicionar Registro!');
                redirect('/questoes/alternativas/'.$this->input->post('questao'));
            }
            
        }else{
            $idQuestao = $this->uri->segment(3);
            
            $dados = array(
                'questao' => $this->questoes->getQuestaoId($idQuestao),
                'alternativas' => $this->questoes->getAlternativas($idQuestao),
                'disciplina' => $this->questoes->getDisciplinas(),
                'temas' => $this->questoes->getTemas(),
                'tipoProva' => $this->questoes->getTipoProva(),
                'ckeditor_texto' => array(
                    'id' => 'texto1', //id da textarea a ser substituída pelo CKEditor
                    'path' => 'layout/admin/js/ckeditor', // caminho da pasta do CKEditor relativo a pasta raiz do CodeIgniter
                    'config' => array(// configurações opcionais
                        'toolbar' => "Basic",
                        'width' => "100%",
                        'height' => "250px",
                    )
                ),
                'ckeditor_texto2' => array(
                    'id' => 'texto2', //id da textarea a ser substituída pelo CKEditor
                    'path' => 'layout/admin/js/ckeditor', // caminho da pasta do CKEditor relativo a pasta raiz do CodeIgniter
                    'config' => array(// configurações opcionais
                        'toolbar' => "Basic",
                        'width' => "100%",
                        'height' => "150px",
                    )
                )
            );

            $this->load->view('/templates/header_html');
            $this->load->view('/templates/header');
            $this->load->view('/templates/sidebar');
            $this->load->view('/questoes/alternativas', $dados);
            $this->load->view('/templates/footer');
            $this->load->view('/templates/footer_html');
        }
    }
    
    // atualiza alternativa correta
    public function upcheck(){
        $dados = array(
            'idalternativa' => $this->input->post('alternativa'),
            'idquestoes' => $this->input->post('questao'),
            'alternativaCorreta' => 1
        );
        
        if($this->questoes->edita_alternativa($dados)){
            
            // atualiza na matriz da questão a questao correta
            $dados2 = array(
                'idquestao' => $this->input->post('questao'),
                'alternativaCorreta' => $this->input->post('alternativa')
            );
            $this->questoes->edita_questao($dados2);
            
            echo '<div class="alert alert-success" style="margin: 20px">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Registro atualizado com sucesso!
                    </div>';
        }else{
            echo '<div class="alert alert-danger" style="margin: 20px">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        Erro ao atualizar registro. Atualize sua página e tente novamente!
                    </div>';
        }
    }
    
    // edita alternativa
    public function edita_alternativas(){
        $dados = array(
            'idalternativa' => $this->input->post('alternativa'),
            'enunciado' => $this->input->post('enunciado'),
            'comentario' => $this->input->post('comentario')
        );
        
        if($this->questoes->edita_alternativa($dados)){
            $this->session->set_flashdata('sucesso', 'Registro atualizado com sucesso!');
            redirect('questoes/alternativas/'.$this->input->post('questao'));
        }else{
            $this->session->set_flashdata('error', 'Erro ao atualizar registro!');
            redirect('questoes/alternativas/'.$this->input->post('questao'));
        }
    }
    
    
    // deleta alternativa
    public function del_alternativa(){
        $id = $this->input->post('alternativa');
        $questao = $this->input->post('questao');
        
        if($this->questoes->del_alternativa($id)){
            $this->session->set_flashdata('sucesso', 'Registro deletado com sucesso!');
            redirect('/questoes/alternativas/'.$questao);
        }else{
            $this->session->set_flashdata('error', 'Erro ao deletar registro!');
            redirect('/questoes/alternativas/'.$questao);
        }
    }
    
    // abre formulário de edição de alternativas
    public function frmEditAlternativa(){
        $id = $this->input->post('alternativa');
        
        $dados = array(
            'ln' => $this->questoes->getAlternativasId($id),
            'ckeditor_texto' => array(
                'id' => 'texto1', //id da textarea a ser substituída pelo CKEditor
                'path' => 'layout/admin/js/ckeditor', // caminho da pasta do CKEditor relativo a pasta raiz do CodeIgniter
                'config' => array(// configurações opcionais
                    'toolbar' => "Basic",
                    'width' => "100%",
                    'height' => "250px",
                )
            ),
            'ckeditor_texto2' => array(
                'id' => 'texto2', //id da textarea a ser substituída pelo CKEditor
                'path' => 'layout/admin/js/ckeditor', // caminho da pasta do CKEditor relativo a pasta raiz do CodeIgniter
                'config' => array(// configurações opcionais
                    'toolbar' => "Basic",
                    'width' => "100%",
                    'height' => "150px",
                )
            )
        );
        
        $this->load->view('questoes/frmEditAlternativa', $dados);
    }
    
    
    
    
    
/*******************************************************************************
 * TIPOS DE TEMAS/SUBTEMAS
 ******************************************************************************/
    public function temas(){
        // verifica se esta sendo buscado algum termo
        $termo = $this->input->get('d');
        if(isset($termo) && !empty($termo)){
          $dados = array(
                'temas' => $this->questoes->getDisciplinasTermos($termo),
                'disciplinas' => $this->questoes->getDisciplinas()
            );  
        }else{
            $dados = array(
                'temas' => $this->questoes->getTemas(),
                'disciplinas' => $this->questoes->getDisciplinas()
            );
        }
        
        
        
        $this->load->view('/templates/header_html');
        $this->load->view('/templates/header');
        $this->load->view('/templates/sidebar');
        $this->load->view('/questoes/temas', $dados);
        $this->load->view('/templates/footer');
        $this->load->view('/templates/footer_html');
    }
    
    // select de tema conforme disciplina
    public function slcTemas(){
        $id = $this->input->post('id');
        $lista = $this->questoes->getTemaDisciplinas($id);
        if(count($lista) == 0){
            echo '<option value="">Não há temas para esta disciplina</option>';
        }else{
            echo '<option value="">Selecione</option>';
            foreach($lista as $ls):
                echo '<option value="'.$ls->idtema.'">'.$ls->nomeTema.'</option>';
            endforeach;
        }
    }
    
    // adiciona tipo de questões
    public function add_tema(){
        $this->form_validation->set_rules('nome', 'NOME DO TEMA', 'trim|required');
        $this->form_validation->set_rules('disciplina', 'DISCIPLINA', 'trim|required');

        if($this->form_validation->run() == TRUE){
        
            $dados = array(
                    'iddisciplinas' => $this->input->post('disciplina'),
                    'nomeTema' => $this->input->post('nome'),
                );
            
            if($this->questoes->add_tema($dados)){
                $this->session->set_flashdata('sucesso', 'Registro adicionado com sucesso!');
                redirect('/questoes/temas');
            }else{
                $this->session->set_flashdata('error', 'Erro ao adicionar Registro!');
                redirect('/questoes/temas');
            }
        }else{
            $this->session->set_flashdata('error', 'Campo NOME DO TEMA Obrigatório!');
            redirect('/questoes/temas');
        }
    }
    
    // atualiza tipo de questões
    public function up_tema(){
        $this->form_validation->set_rules('nome', 'NOME DO TEMA', 'trim|required');
        $this->form_validation->set_rules('disciplina', 'DISCIPLINA', 'trim|required');


        if($this->form_validation->run() == TRUE){
        
            $dados = array(
                    'id' => $this->input->post('tema'),
                    'disciplina' => $this->input->post('disciplina'),
                    'nome' => $this->input->post('nome'),
                );
            
            if($this->questoes->atualiza_tema($dados)){
                $this->session->set_flashdata('sucesso', 'Registro atualizado com sucesso!');
                redirect('/questoes/temas');
            }else{
                $this->session->set_flashdata('error', 'Erro ao atualizar Registro!');
                redirect('/questoes/temas');
            }
        }else{
            $this->session->set_flashdata('error', 'Campo NOME DO TEMA e DISCIPLINAS Obrigatório!');
            redirect('/questoes/temas');
        }
    }
    
    // deleta tipo de questão
    public function del_tema(){
        if($this->questoes->excluir_tema($this->input->post('tema'))){
            $this->session->set_flashdata('sucesso', 'Registro deletado com sucesso!');
            redirect('/questoes/temas');
        }else{
            $this->session->set_flashdata('error', 'Erro ao deletar Registro!');
            redirect('/questoes/temas');
        }
    }
    
    /****** SUBTEMAS ******/
    // select de subtemas
    public function slcSubtema(){
        $id = $this->input->post('id');
        
        $lista = $this->questoes->getSubtemas($id);
        
        if(count($lista) == 0){
            echo '<option>Este Tema não possui Subtemas</option>';
        }else{
            echo '<option value="">Selecione</option>';
            foreach($lista as $ls):
                echo '<option value="'.$ls->idsubtemas.'">'.$ls->nomeSubtema.'</option>';
            endforeach;
        }
        
    }
    
    
    public function add_subtema(){
        $this->form_validation->set_rules('nome', 'NOME DO SUBTEMA', 'trim|required');
        $this->form_validation->set_rules('tema', 'TEMA', 'trim|required');


        if($this->form_validation->run() == TRUE){
        
            $dados = array(
                    'idtema' => $this->input->post('tema'),
                    'nomeSubtema' => $this->input->post('nome')
                );
            
            if($this->questoes->add_subtema($dados)){
                $this->session->set_flashdata('sucesso', 'Registro adicionado com sucesso!');
                redirect('/questoes/temas');
            }else{
                $this->session->set_flashdata('error', 'Erro ao adicionar Registro!');
                redirect('/questoes/temas');
            }
        }else{
            $this->session->set_flashdata('error', 'Campo NOME DO SUBTEMA e TEMA Obrigatório!');
            redirect('/questoes/temas');
        }
    }
    public function up_subtema(){
        $this->form_validation->set_rules('nome', 'NOME DO SUBTEMA', 'trim|required');
        $this->form_validation->set_rules('tema', 'TEMA', 'trim|required');


        if($this->form_validation->run() == TRUE){
        
            $dados = array(
                    'id' => $this->input->post('idsub'),
                    'idtema' => $this->input->post('tema'),
                    'nomesubtema' => $this->input->post('nome')
                );
            
            if($this->questoes->up_subtema($dados)){
                $this->session->set_flashdata('sucesso', 'Registro atualizado com sucesso!');
                redirect('/questoes/temas');
            }else{
                $this->session->set_flashdata('error', 'Erro ao atualizar Registro!');
                redirect('/questoes/temas');
            }
        }else{
            $this->session->set_flashdata('error', 'Campo NOME DO SUBTEMA e TEMA Obrigatório!');
            redirect('/questoes/temas');
        }
    }
    public function del_subtema(){
        if($this->questoes->del_subtema($this->input->post('tema'))){
            $this->session->set_flashdata('sucesso', 'Registro delatado com sucesso!');
            redirect('/questoes/temas');
        }else{
            $this->session->set_flashdata('error', 'Erro ao deletar Registro!');
            redirect('/questoes/temas');
        }
    }
/*******************************************************************************
 * TIPOS DE PROVAS
 ******************************************************************************/
    public function tiposprovas(){
        $dados = array(
            'lista' => $this->questoes->getTipoProva()
        );
        
        $this->load->view('/templates/header_html');
        $this->load->view('/templates/header');
        $this->load->view('/templates/sidebar');
        $this->load->view('/questoes/tiposprovas', $dados);
        $this->load->view('/templates/footer');
        $this->load->view('/templates/footer_html');
    }
    
    // adiciona tipo de questões
    public function add_tipo(){
        $this->form_validation->set_rules('tipo', 'TIPO REGISTRO', 'trim|required');

        if($this->form_validation->run() == TRUE){
        
            $dados = array('tipoProva' => $this->input->post('tipo'));
            
            if($this->questoes->add_tipo($dados)){
                $this->session->set_flashdata('sucesso', 'Registro adicionado com sucesso!');
                redirect('/questoes/tiposprovas');
            }else{
                $this->session->set_flashdata('error', 'Erro ao adicionar Registro!');
                redirect('/questoes/tiposprovas');
            }
        }else{
            $this->session->set_flashdata('error', 'Campo Tipo de Registro Obrigatório!');
            redirect('/questoes/tiposprovas');
        }
    }
    
    // atualiza tipo de questões
    public function up_tipo(){
        $this->form_validation->set_rules('tipo', 'TIPO REGISTRO', 'trim|required');

        if($this->form_validation->run() == TRUE){
        
            $dados = array('idtipo' => $this->input->post('idtipo'), 'tipoProva' => $this->input->post('tipo'));
            
            if($this->questoes->atualiza_tipo($dados)){
                $this->session->set_flashdata('sucesso', 'Registro atualizado com sucesso!');
                redirect('/questoes/tiposprovas');
            }else{
                $this->session->set_flashdata('error', 'Erro ao atualizar Registro!');
                redirect('/questoes/tiposprovas');
            }
        }else{
            $this->session->set_flashdata('error', 'Campo Tipo de Registro Obrigatório!');
            redirect('/questoes/tiposprovas');
        }
    }
    
    // deleta tipo de questão
    public function del_tipo(){
        if($this->questoes->excluir_tipo($this->input->post('idtipo'))){
            $this->session->set_flashdata('sucesso', 'Registro deletado com sucesso!');
            redirect('/questoes/tiposprovas');
        }else{
            $this->session->set_flashdata('error', 'Erro ao deletar Registro!');
            redirect('/questoes/tiposprovas');
        }
    }
/*******************************************************************************
 * DISCIPLINAS
 ******************************************************************************/
    public function disciplinas(){
        $dados = array(
            'lista' => $this->questoes->getDisciplinas()
        );
        
        $this->load->view('/templates/header_html');
        $this->load->view('/templates/header');
        $this->load->view('/templates/sidebar');
        $this->load->view('/questoes/disciplinas', $dados);
        $this->load->view('/templates/footer');
        $this->load->view('/templates/footer_html');
    }
    
    
    
    // adiciona tipo de questões
    public function add_disciplina(){
        $this->form_validation->set_rules('nome', 'DISCIPLINA', 'trim|required');

        if($this->form_validation->run() == TRUE){
        
            $dados = array('nomeDisciplina' => $this->input->post('nome'));
            
            if($this->questoes->add_disciplina($dados)){
                $this->session->set_flashdata('sucesso', 'Registro adicionado com sucesso!');
                redirect('/questoes/disciplinas');
            }else{
                $this->session->set_flashdata('error', 'Erro ao adicionar Registro!');
                redirect('/questoes/disciplinas');
            }
        }else{
            $this->session->set_flashdata('error', 'Campo DISCIPLINA Obrigatório!');
            redirect('/questoes/disciplinas');
        }
    }
    
    // atualiza tipo de questões
    public function up_disciplina(){
        $this->form_validation->set_rules('nome', 'DISCIPLINA', 'trim|required');

        if($this->form_validation->run() == TRUE){
        
            $dados = array('id' => $this->input->post('iddisciplina'), 'nomeDisciplina' => $this->input->post('nome'));
            
            if($this->questoes->atualiza_disciplina($dados)){
                $this->session->set_flashdata('sucesso', 'Registro atualizado com sucesso!');
                redirect('/questoes/disciplinas');
            }else{
                $this->session->set_flashdata('error', 'Erro ao atualizar Registro!');
                redirect('/questoes/disciplinas');
            }
        }else{
            $this->session->set_flashdata('error', 'Campo Tipo de Registro Obrigatório!');
            redirect('/questoes/disciplinas');
        }
    }
    
    // deleta tipo de questão
    public function del_disciplina(){
        if($this->questoes->excluir_disciplina($this->input->post('iddisciplina'))){
            $this->session->set_flashdata('sucesso', 'Registro deletado com sucesso!');
            redirect('/questoes/disciplinas');
        }else{
            $this->session->set_flashdata('error', 'Erro ao deletar Registro!');
            redirect('/questoes/disciplinas');
        }
    }
    
    
    
    
}
