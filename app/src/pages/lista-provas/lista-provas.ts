import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, LoadingController } from 'ionic-angular';
import { ProvasProvider } from '../../providers/provas/provas';
import { ConfigProvider } from '../../providers/config/config';
import { ProvaPage } from '../prova/prova';
import { StatusBar } from '@ionic-native/status-bar';

/**
 * Generated class for the ListaProvasPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-lista-provas',
  templateUrl: 'lista-provas.html',
  providers: [
    ProvasProvider,
    ConfigProvider
  ]
})
export class ListaProvasPage {

  listaProvas:Array<any>;
  status_conexao:number;

  constructor(
    public navCtrl: NavController, 
    public navParams: NavParams,
    public loadingCtrl: LoadingController,
    private statusBar: StatusBar,
    private provasProvider: ProvasProvider,
    private configProvider: ConfigProvider
  ) {
    // let status bar overlay webview 
    this.statusBar.overlaysWebView(false);
    // set status bar to white
    this.statusBar.backgroundColorByHexString('#09a266');
    
    let u = this.configProvider.getConfigData();
    let usuario = JSON.parse(u);
    this.getLoader();
    // lista provas
    this.getProvas(usuario.id);
  }


  // lista provas realizadas pelo usuário
  getProvas(idUsuario:number){
    this.provasProvider.getProvas(idUsuario)
      .then((result:any) => {
        this.listaProvas = result.dados;
        this.status_conexao = result.status_conexao;
        console.log(this.listaProvas);
        //return this.listaProvas;
      })
      .catch((error:any) => {
        console.log(error);
      });
  }

  // abre prova 
  getAbreProva(idProva:number){
    console.log('abre prova ' + idProva);
    this.navCtrl.push(ProvaPage, {id:idProva});
  }


  getLoader() {
    let loader = this.loadingCtrl.create({
      content: "Aguarde carregando...",
      duration: 1500
    });
    loader.present();
  }
}
