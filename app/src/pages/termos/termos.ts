import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { StatusBar } from '@ionic-native/status-bar';

/**
 * Generated class for the TermosPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-termos',
  templateUrl: 'termos.html',
})
export class TermosPage {

  constructor(
    public navCtrl: NavController, 
    public navParams: NavParams,
    private statusBar: StatusBar
  ) {
    // let status bar overlay webview 
    this.statusBar.overlaysWebView(false);
    // set status bar to white
    this.statusBar.backgroundColorByHexString('#09a266');
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad TermosPage');
  }

}
