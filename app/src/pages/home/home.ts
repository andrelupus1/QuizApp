import { Component} from '@angular/core';
import { NavController, ToastController, LoadingController } from 'ionic-angular';
import { StatusBar } from '@ionic-native/status-bar';
import { QuestoesProvider } from '../../providers/questoes/questoes';
import { ConfigProvider } from '../../providers/config/config';
import { GeraProvaPage } from '../gera-prova/gera-prova';
import { RankingPage } from '../ranking/ranking';
import { ListaProvasPage } from '../lista-provas/lista-provas';
import { UsuariosProvider } from '../../providers/usuarios/usuarios';
import { BannerProvider } from '../../providers/banner/banner';

@Component({
  selector: 'page-home',
  templateUrl: 'home.html',
  providers: [
    QuestoesProvider,
    ConfigProvider,
    UsuariosProvider,
    BannerProvider
  ]
})
export class HomePage {
  totalQuestoes:number;
  acertoGlobal:any;
  repeticaoMedia:number;
  posicaoRanking:number;
  totalRanking:number;
  imgBanner:any;
  urlBanner:any;
  //banner:any= this.getBanner();

  constructor(
    public navCtrl: NavController,
    public toastCtrl: ToastController,
    public loadingCtrl: LoadingController,
    private statusBar: StatusBar,
    private questoesProvider: QuestoesProvider,
    private configProvider: ConfigProvider,
    private usuariosProvider: UsuariosProvider,
    private bannerProvider: BannerProvider,
  ) {
    // let status bar overlay webview 
    this.statusBar.overlaysWebView(false);
    // set status bar to white
    this.statusBar.backgroundColorByHexString('#1a435c');
    this.getLoader();
    // carrega dados do usuário via localStorage
    let u = this.configProvider.getConfigData();
    let usuario = JSON.parse(u);
    this.getTotalQuestoesUsuario(usuario.id);
    this.getAcertoGlobal(usuario.id);
    this.getRepeticaoQuestoes(usuario.id);
    this.getRankingPosicao(usuario.id);
    this.getBanner();//Habilitar Banner
  }
  // redirect para tela de MontarProva
  getGerarrProva(){//getMontarProva
    this.navCtrl.setRoot(GeraProvaPage);
  }

  // redirect ranking
  getRanking(){
    this.navCtrl.setRoot(RankingPage);
  }

  // redirect minhas provas
  getProvas(){
    this.navCtrl.setRoot(ListaProvasPage);
  }

  // lista total de questoes do usuário
  getTotalQuestoesUsuario(idUsuario:number){
    this.questoesProvider.getTodasQuestoes(idUsuario)
      .then((result:any) => {
        console.log(result);
        this.totalQuestoes = result.dados.total_questoes;
      })
      .catch((error:any) => {
        console.log(error);
      });
  }

  // lista taxa de acerto global
  getAcertoGlobal(idUsuario:number){
    this.usuariosProvider.getAcertoGlobal(idUsuario)
      .then((result:any) => {
        console.log('**************  MEDIA GLOBAL **************************');
        console.log(result.dados.mediaGlobal);
        this.acertoGlobal = result.dados.mediaGlobal;
      })
      .catch((error:any) => {
        console.log(error);
      });
  }

  // lista taxa de repetição média de questões
  getRepeticaoQuestoes(idUsuario:number){
    this.questoesProvider.getQuestoesRepetidas(idUsuario)
      .then((result:any) => {
        console.log("********* QUESTÕES REPETIDAS ************");
        console.log(result);
        this.repeticaoMedia = result.mediaRepeticao;
      })
      .catch((error:any) => {
        console.log(error);
      });
  }

  // lista posicao ranking
  getRankingPosicao(idUsuario:number){
    this.usuariosProvider.getPosicaoRanking(idUsuario)
      .then((result:any) => {
        console.log("***************** POSICAO RANKING ************");
        console.log(result);
        this.posicaoRanking = result.posicao;
        this.totalRanking = result.totalUsuarios;
      })
      .catch((error:any) => {
        console.log(error);
      });
  }

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

  showMessage() {
    let toast = this.toastCtrl.create({
      message: 'Olá João, bem-vindo!',
      duration: 3000,
      position: 'top'
    });
    toast.present();
  }

  getLoader() {
    let loader = this.loadingCtrl.create({
      content: "Aguarde carregando...",
      duration: 1200
    });
    loader.present();
  }

  
  

}
