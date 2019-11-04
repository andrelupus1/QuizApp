import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { ProvasProvider } from '../../providers/provas/provas';
import { StatusBar } from '@ionic-native/status-bar';

/**
 * Generated class for the TemasPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-temas',
  templateUrl: 'temas.html',
})
export class TemasPage {

  listaTema:Array<any>;

  constructor(
    public navCtrl: NavController, 
    public navParams: NavParams,
    private statusBar: StatusBar,
    private provasProvider: ProvasProvider
  ) {
    // let status bar overlay webview 
    this.statusBar.overlaysWebView(false);
    // set status bar to white
    this.statusBar.backgroundColorByHexString('#09a266');
    this.getTemas();
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad TemasPage');
  }

  // lista temas de questões
  getTemas(){
    this.provasProvider.getTemasProva()
      .then((result:any) => {
        this.listaTema = result.dados;
        console.log(this.listaTema);
        return this.listaTema;
      })
      .catch((error:any) => {
        console.log(error);
      });
  }

}
