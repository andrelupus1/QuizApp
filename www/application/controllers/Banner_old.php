<?php if (!defined("BASEPATH")) exit ("Você não pode carregar esta página diretamante.");
 /*
 * Model de Gerenciamento de Usuários
 * Autor: ARTE DESIGN PA 
 * Webite: www.artedesignpa com br
 */  
class Banner extends CI_Controller{

    public function __construct() {
        parent::__construct();

        if ($this->session->userdata('usuarioLogado') == false) {
            redirect('/home');
        }
        $this->load->model('Banner_model', 'banner');

    }

    // lista todos
    public function index(){
    $dados = array(
        'banner' => $this->banner->listatodas()
    );
        $this->load->view('/templates/header_html');
        $this->load->view('/templates/header');
        $this->load->view('/templates/sidebar');
        $this->load->view('/banners/index_banners', $dados);
        $this->load->view('/templates/footer');
        $this->load->view('/templates/footer_html');

    }

    // adiciona página
    public function add(){

        $this->form_validation->set_rules('txtNome', 'Titulo', 'required|trim');
        if($this->form_validation->run() == TRUE){

            // faz upload
            $config['upload_path'] = './uploads/banner/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            //$config['max_size'] = '2048';
            //$config['max_width'] = '800';
            //$config['max_height'] = '600';
            $config['encrypt_name'] = false;
            $this->load->library('upload', $config);

            if(! $this->upload->do_upload()){
                $this->session->set_flashdata('msg', 'Erro ao criar banner!!! '.$this->upload->display_errors());
                redirect("banner");
            }else{
                $arquivo_upado = $this->upload->data();
                $dados = array(
                    'ordemBanner' => $this->input->post('txtOrdem'),
                    'nomeBanner' => $this->input->post('txtNome'),
                    'imgBanner' => $arquivo_upado['file_name'],
                    'urlBanner' => $this->input->post('txtUrl'),
                    'statusBanner' => $this->input->post('slcStatus'),
                    'posicaoBanner' => $this->input->post('slcPosicao')
                );

                if($this->banner->adicionar($dados)){
                    // configura mensagem
                    $this->session->set_flashdata('sucesso', 'Banner cadastrado com sucesso!!!');
                    redirect('banner');
                }else{
                    // configura mensagem
                    $this->session->set_flashdata('erro', 'Erro ao criar banner!!!');
                    redirect("banner");
                }
            }
        }else{
            $this->session->set_flashdata('erro', 'Erro ao criar banner!!!');
            redirect("banner");
        }
    }

    // atualiza pagina
    public function editar($id){

        // validação do form
        $this->form_validation->set_rules('txtNome', 'Titulo', 'required|trim');

        if($this->form_validation->run() == TRUE){


            $dados = array(
                'idBanner' => $this->input->post('banner'),
                'ordemBanner' => $this->input->post('txtOrdem'),
                'nomeBanner' => $this->input->post('txtNome'),
                'urlBanner' => $this->input->post('txtUrl'),                
                'statusBanner' => $this->input->post('slcStatus'),
                'posicaoBanner' => $this->input->post('slcPosicao')
            );

                if($this->banner->atualiza($dados)){
                    $this->session->set_flashdata('sucesso', 'Banner Atualizado com sucesso!!!');
                    redirect('banner/');
                }else{
                    $this->session->set_flashdata('erro', 'Erro ao atualizar convênio!!!');
                    redirect('banner/editar/'.$this->input->post('banner'));
                }
        }else{

            $dados = array(
               'banner' => $this->banner->lista_por_id($this->uri->segment(3)) //antes 4! AD
            );

            $this->load->view('/templates/header_html');
            $this->load->view('/templates/header');
            $this->load->view('/templates/sidebar');
            $this->load->view('/banners/editar_banner', $dados);
            $this->load->view('/templates/footer');
            $this->load->view('/templates/footer_html');
        }

    }

    /*editar ordem do banner*/
    public function editarordem() {
        $dados = array(
                'idBanner' => $this->input->post('id'),
                'ordemBanner' => $this->input->post('ordem')
        );

        if($this->banner->atualiza($dados)){
            echo '<div class="alert alert-success" role="alert">  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Ordem atualizada com sucesso!! </div>';
        }else{
            echo '<div class="alert alert-danger" role="alert">  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Erro ao editar ordem!!! </div>0';
        }

    }

    /** atualiza a logo do conveniado ***/
    public function atualizaimg(){

            // faz upload
            $config['upload_path'] = './uploads/banner/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            //$config['max_size'] = '2048';
            $config['encrypt_name'] = false;
            $this->load->library('upload', $config);

            if(! $this->upload->do_upload()){
                $this->session->set_flashdata('erro', 'Erro ao criar banner!!! '.$this->upload->display_errors());
                redirect("banner/editar/".$this->input->post('banner'));
            }else{
                $arquivo_upado = $this->upload->data();
                $dados = array(
                    'idBanner'=> $this->input->post('banner'),
                    'imgBanner' => $arquivo_upado['file_name']
                );



                if($this->banner->atualiza_img($dados)){
                    // exclui arquivo
                    $this->load->helper('file');
                    $arquivo = 'uploads/banner/'.$this->input->post('imgAntiga');
                    unlink($arquivo);


                    // configura mensagem
                    $this->session->set_flashdata('sucesso', 'Imagem salva com sucesso!!!');
                    redirect('banner/editar/'.$this->input->post('banner'));
                }else{
                    // configura mensagem
                    $this->session->set_flashdata('erro', 'Erro ao adicionar imagem!!!');
                    redirect('banner/editar/'.$this->input->post('banner'));
                }
            }
    }


    public function excluir(){
        if($this->banner->excluir($this->uri->segment(3))){//Padrão 3
            // exclui arquivo
            $this->load->helper('file');
            $arquivo= 'uploads/banner'.$this->uri->segment(3);//Pardrão 3, pois adiciona entre / (barra)
            unlink($arquivo);//Comando excluir arquivo
            $this->session->set_flashdata("sucesso", "Banner deletado com sucesso!!");
            redirect('banner/');
        }else{
            $this->session->set_flashdata("erro", "Erro ao deletar Banner, tente novamente!!");
            redirect('banner/');
        }
    }
}
