import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, ViewController, ModalController } from 'ionic-angular';
import { StatusBar } from '@ionic-native/status-bar';

/**
 * Generated class for the ResumoProvaPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-resumo-prova',
  templateUrl: 'resumo-prova.html',
})
export class ResumoProvaPage {
  dados:any;
  constructor(
    public navCtrl: NavController, 
    public navParams: NavParams,
    public viewCtrl: ViewController,
    public modalCtrl: ModalController,
    private statusBar: StatusBar
  ) {
    // let status bar overlay webview 
    this.statusBar.overlaysWebView(false);
    // set status bar to white
    this.statusBar.backgroundColorByHexString('#09a266');
    console.log("dados vindos: " + this.navParams.data(this.dados));
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad ResumoProvaPage');
  }

  getCloseModal(){
    this.viewCtrl.dismiss();
  }

}
