import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { ProvasProvider } from '../../providers/provas/provas';
import { StatusBar } from '@ionic-native/status-bar';

/**
 * Generated class for the RankingPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-ranking',
  templateUrl: 'ranking.html',
  providers: [
    ProvasProvider
  ]
})
export class RankingPage {

  listaRanking:Array<any>;
  listaUsuarios:Array<any>;

  constructor(
    public navCtrl: NavController, 
    public navParams: NavParams,
    private provasProvider: ProvasProvider,
    private statusBar: StatusBar
  ) {
    // let status bar overlay webview 
    this.statusBar.overlaysWebView(false);
    // set status bar to white
    this.statusBar.backgroundColorByHexString('#09a266');
    this.getRanking();
  }


  getRanking(){
    this.provasProvider.getRanking()
      .then((result:any) => {
        this.listaRanking = result.dados;
        this.listaUsuarios = result.dados.usuarios;

        console.log(this.listaRanking);  
        
      })
      .catch((error:any) => {
        console.log(error);
      });
    
    
  }

}
