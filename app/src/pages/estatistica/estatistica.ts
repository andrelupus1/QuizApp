import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { QuestoesProvider } from '../../providers/questoes/questoes';
import { LoadingController } from 'ionic-angular/components/loading/loading-controller';
import { ConfigProvider } from '../../providers/config/config';
import { UsuariosProvider } from '../../providers/usuarios/usuarios';
import { DisciplinasProvider } from '../../providers/disciplinas/disciplinas';
import { ProvasProvider } from '../../providers/provas/provas';
import { StatusBar } from '@ionic-native/status-bar';

/**
 * Generated class for the EstatisticaPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-estatistica',
  templateUrl: 'estatistica.html',
  providers: [
    QuestoesProvider,
    ConfigProvider,
    UsuariosProvider,
    DisciplinasProvider,
    ProvasProvider
  ]
})
export class EstatisticaPage {

  totalQuestoes:number;
  acertoGlobal:number;
  repeticaoMedia:number;
  posicaoRanking:number;
  totalRanking:number;
  listaDisciplinas:Array<any>;
  listaTipoProva:Array<any>;

  constructor(
    public navCtrl: NavController, 
    public navParams: NavParams,
    public loadingCtrl: LoadingController,
    private statusBar: StatusBar,
    private questoesProvider: QuestoesProvider,
    private configProvider: ConfigProvider,
    private usuariosProvider: UsuariosProvider,
    private disciplinasProvider: DisciplinasProvider,
    private provasProvider: ProvasProvider
  ) {
    // let status bar overlay webview 
    this.statusBar.overlaysWebView(false);
    // set status bar to white
    this.statusBar.backgroundColorByHexString('#09a266');

    this.getLoader();
    // carrega dados do usuário via localStorage
    let u = this.configProvider.getConfigData();
    let usuario = JSON.parse(u);

    this.getTotalQuestoesUsuario(usuario.id);
    this.getAcertoGlobal(usuario.id);
    this.getRepeticaoQuestoes(usuario.id);
    this.getRankingPosicao(usuario.id);
    this.getDisciplinas(usuario.id);
    this.getTiposProvas(usuario.id);
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad EstatisticaPage');
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

  // lista tipos de provas que o usuário realizou
  getTiposProvas(idUsuario:number){
    this.provasProvider.getMediaTipoProva(idUsuario)
      .then((result:any) => {
        console.log("************ TIPOS DE PROVAS ***********");
        console.log(result);
        this.listaTipoProva = result;
      })
      .catch((error:any) => {
        console.log(error);
      });
  }

  // lista disciplinas utilizadas em questões
  getDisciplinas(idUsuario:number){
    this.disciplinasProvider.getDisciplinasQuestoes(idUsuario)
      .then((result:any) => {
        console.log('****************** DISCIPLINAS ******************');
        console.log(result);
        this.listaDisciplinas = result;
      })
      .catch((error:any) => {
        console.log(error.error); 
      });
  }

  getLoader() {
    let loader = this.loadingCtrl.create({
      content: "Aguarde carregando...",
      duration: 1200
    });
    loader.present();
  }


}
