<?php
class Banner extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        $this->load->model('Banner_model', 'banners');
        $this->load->helper('array');
        $this->load->helper('rand');
    }
    
    public function index(){
        echo '<h1>Acesso Negado!</h1>';
    }

    public function getBanner(){
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=UTF-8');
        // Se houver banner retornar um, senão retorna null
      /*   //FUNCIONANDO
        $todosBanner = $this->banners->todosBanner();//Retorna todos os banners ativos como array
        $todosBannerCopy = $todosBanner;//Copia
        $todosBanner = [array_rand($todosBanner)]; // sorteia um banner e retornar por array
        $indice = $todosBanner[0];//Pega o indice na primeira posição após sorteio
        $bannerSelect = $todosBannerCopy[$indice]; //Recebendo array sorteado pelo indice
        //FUNCIONANDO FIM */
        $todosBanner = $this->banners->todosBanner();//Retorna todos os banners ativos como array
        $todosBannerCopy = $todosBanner;//Copia
        $banners_indices= $this->banners->indice($acao=0,$valor=0);//JÁ SORTEADOS POR ID OU INDICE?
        //SORTEIA
        do{
		$sair=0;
		$todosBanner = [array_rand($todosBanner)];//SORTEIA
        $indice = $todosBanner[0];
        if($banners_indices!=NULL){
            foreach($banners_indices as $row){
                $sorteados[] = $row['indice'];
            }
        }else{
            $sorteados[]= 10;
            $this->banners->indice($acao=1,$valor=10);
        }
            if((in_array($indice,$sorteados))==false){//Se não tiver sido sorteado. Obr: O in_array funciona melhor que o array_search
                array_push($sorteados, $indice); //Adicona nos n. já sorteados
                $this->banners->indice($acao=1,$valor=$indice);
                $sair=1;//Sair
            }else{
                if((count($sorteados))>=(count($todosBannerCopy))){//mudar para >=
                    if($this->banners->indice($acao=2,$valor=0)){
                       break;
                    }
                }
            }  
        }while($sair==0);
        $indice = $todosBanner[0];//Pega o indice na primeira posição após sorteio
        $bannerSelect = $todosBannerCopy[$indice]; //Recebendo array sorteado pelo indice
        //CONTADOR DE EXIBIÇÃO: CONTA SEMPRE QUE GERADO
        if($bannerSelect['idBanner']!=NULL){
            $i = $bannerSelect['exibicaoBanner'];
            $banner = $bannerSelect; //copia
            $banner = array (
                'idBanner'=>$banner['idBanner'],
                'exibicaoBanner' => ++$i //primeiro incrementa, depois recebe.
            );
            $this->banners->atualiza($banner);
        }
        //ENVIA BANNER E LINK PARA O APP
        $jsonDados = array(                        
            'urlBanner' => $bannerSelect['urlBanner'],
            'imgBanner' => base_url('/uploads/banner/'.$bannerSelect['imgBanner'])
        );
        echo json_encode( $jsonDados , JSON_UNESCAPED_UNICODE);
    }
    public function cliqueBanner($id , $url){
        $banner = $this->banners->lista_por_id($id);//recebe banner por id
        $dados = array (//Recebendo o id atraves do indice sorteado;
            
        /*  'urlBanner'=>$bannerSelect['urlBanner'],
            'imgBanner'=>$bannerSelect['imgBanner']
            'ordemBanner'=>$bannerSelect['ordemBanner'],
            'nomeBanner'=>$bannerSelect['nomeBanner'],
            'legendaBanner'=>$bannerSelect['legendaBanner'],
            'posicaoBanner'=>$bannerSelect['posicaoBanner'],
            'tipoBanner'=> $bannerSelect['tipoBanner'],
            'statusBanner'=>$bannerSelect['statusBanner'],
            'exibicaoBanner'=>$banner['exibicaoBanner'], */
            'idBanner'=>$banner['idBanner'],
            'cliqueBanner'=>$banner['cliqueBanner']
        );  
        if($this->banners->atualiza($dados)){
            redirect($url);
        }
    }
}