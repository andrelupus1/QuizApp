import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { ProvasProvider } from '../../providers/provas/provas';
import { HomePage } from '../home/home';

import { LoadingController } from 'ionic-angular/components/loading/loading-controller';
import { ToastController } from 'ionic-angular/components/toast/toast-controller';
import { AlertController } from 'ionic-angular/components/alert/alert-controller';
import { StatusBar } from '@ionic-native/status-bar';
import { ImageViewerController } from 'ionic-img-viewer';
import { BannerProvider } from '../../providers/banner/banner';


/**
 * Generated class for the ProvaPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-prova',
  templateUrl: 'prova.html',
  providers: [
  BannerProvider
]
})
export class ProvaPage {
  _imageViewerCtrl: ImageViewerController;

  dataHora:number = Date.now();
  questoes:number = 1;
  idAvaliacao:number;
  avaliacao:number;
  dadosProva:Array<any>;
  listaQuestoes:Array<any>;
  statusQuest:number;
  statusAvaliacao:number;
  imgBanner:any;
  urlBanner:any;
  constructor(
    public navCtrl: NavController, 
    public navParams: NavParams,
    public loadingCtrl: LoadingController,
    public toastCtrl: ToastController,
    public alertCtrl: AlertController,
    public imageViewerCtrl: ImageViewerController,
    private statusBar: StatusBar,
    private provasProvider: ProvasProvider,
    private bannerProvider: BannerProvider
  ) {
    // let status bar overlay webview 
    this.statusBar.overlaysWebView(false);
    // set status bar to white
    this.statusBar.backgroundColorByHexString('#09a266');
    this.getLoader();
    this.idAvaliacao = this.navParams.get('id');
    this.getProva(this.idAvaliacao);
    console.log('Questão ativa: ' + this.questoes);
    this.getBanner();//Habilitar Banner
  }

  getProva(id:number){
    console.log("chamar prova: " + id);

    this.provasProvider.getProvaId(id)
      .then((result:any) => {        

        this.dadosProva = result.dados_avaliacao;
        this.listaQuestoes = result.questoes;


        console.log(this.dadosProva);
        console.log('***********************************');
        console.log(this.listaQuestoes);
        console.log('***********************************');
      
      })
      .catch((error:any) => {
        console.log(error);
      });
  }
  // carrega questão
  mudaQuestao(qst:number){
    this.questoes = qst;
  }

  // registra resposta
  getResposta(idAvaliacao:number, idQuestao:number, idAlt:number, correta:number){
    console.log(idQuestao + ' + ' + idAlt);
    this.statusQuest = 1;

    this.provasProvider.getResposta(idAvaliacao, idQuestao, idAlt)
      .then((result:any) => {
          console.log(result);
          this.statusAvaliacao = result.dados.statusAvaliacao;
          
          if(correta == 1){
            this.showMessage('Alternativa Correta!');
            
          }else{      
            this.showMessage('Ops! Alternativa errada!');
          }
          this.getLoader();
          this.getProva(idAvaliacao);

          if(this.statusAvaliacao == 2){
           
            let msg = "Percentual de Acertos: "+ result.dados.percAcerto +"% <br />";
                msg += "Qtde. de Acertos: " + result.dados.qtdeAcertos + " <br />";
                msg += "Qtde. de Erros: "+ result.dados.qtdeErros;

                let alert = this.alertCtrl.create({
                  title: 'Avaliação Concluída!',
                  message: msg,
                  buttons: [
                    {
                      text: 'Sair',
                      handler: () => {
                        this.navCtrl.setRoot(HomePage);
                      }
                    },
                    {
                      text: 'Continuar',
                      handler: () => {
                        console.log('Agree clicked');
                      }
                    }
                  ]
                });
                alert.present();
          }

      })
      .catch((error:any) => {
        console.log(error);
      });

  }

  // favorita questão
  questaoFavorita(idAvaliacao:number, idQuestao:number, status:number){
    this.provasProvider.getSalvaFavorita(idQuestao, status)
      .then((result:any) => {
          // formata mensagem
          if(status == 1){
            this.showMessage('Questão adicionada como favorita com sucesso!');           
          }else{
            this.showMessage('Questão removida de favoritos com sucesso!'); 
          }
          this.getLoader();
          this.getProva(idAvaliacao);       
      })
      .catch((error:any) => {
          this.showMessage('Ops! Houve um erro ao salvar questão como favorita, tente novamente!');
          console.log(error);
      });
  }

  // lista média de tipos de provas realizadas pelos usuários
  getTipoProvaUsuario(idUsuario:number){
    this.provasProvider.getMediaTipoProva(idUsuario)
      .then((result:any) => {
        console.log(result);
      })
      .catch((error:any) => {
        console.log(error);
      });
  }

  // abre imagem
  getOpenImage(img:string){
    
  }

//Banner
getBanner(){
  this.bannerProvider.getBanner()
    .then((result:any) => {
      console.log("*************** BANNER ************");
      console.log(result);
      //this.banner = result;//Antes result.banner
      this.urlBanner = result.urlBanner;
      this.imgBanner= result.imgBanner;
    })
    .catch((error:any) => {
      console.log(error);
    });
}
  // loader da tela
  getLoader() {
    let loader = this.loadingCtrl.create({
      content: "Carregando questões, Aguarde...",
      duration: 2500
    });
    loader.present();
  }
  // exibe mensagens
  showMessage(msg:string) {
    let toast = this.toastCtrl.create({
      message: msg,
      duration: 3000,
      position: 'top'
    });
    toast.present();
  }
  
  

}
