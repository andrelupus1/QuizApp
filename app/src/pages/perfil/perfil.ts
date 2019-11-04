import { Component, ViewChild } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';

import { ConfigProvider } from '../../providers/config/config';
import { UsuariosProvider } from '../../providers/usuarios/usuarios';
import { ToastController } from 'ionic-angular/components/toast/toast-controller';
import { StatusBar } from '@ionic-native/status-bar';
/**
 * Generated class for the PerfilPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-perfil',
  templateUrl: 'perfil.html',
  providers: [
    ConfigProvider,
    UsuariosProvider
  ]
})
export class PerfilPage {

  user:Array<any>;
  @ViewChild('id') id;
  @ViewChild('nome') nome;
  @ViewChild('email') email;
  @ViewChild('nick') nick;
  @ViewChild('senha') senha;
  @ViewChild('crm') crm;
  @ViewChild('uf') uf;
  estados:Array<any>;

  constructor(
    public navCtrl: NavController, 
    public navParams: NavParams,
    public toastCtrl: ToastController,
    private statusBar: StatusBar,
    private configProvider: ConfigProvider,
    private usuariosProvider: UsuariosProvider
  ) {
    // let status bar overlay webview 
    this.statusBar.overlaysWebView(false);
    // set status bar to white
    this.statusBar.backgroundColorByHexString('#09a266');
    
    let u = this.configProvider.getConfigData();
    this.user = JSON.parse(u);    
    console.log(this.user);    

    this.estados = [
            { "Sigla": "AC" },
            { "Sigla": "AL" },
            { "Sigla": "AM" },
            { "Sigla": "AP" },
            { "Sigla": "BA" },
            { "Sigla": "CE" },
            { "Sigla": "DF" },
            { "Sigla": "ES" },
            { "Sigla": "GO" },
            { "Sigla": "MA" },
            { "Sigla": "MG" },
            { "Sigla": "MS" },
            { "Sigla": "MT" },
            { "Sigla": "PA" },
            { "Sigla": "PB" },
            { "Sigla": "PE" },
            { "Sigla": "PI" },
            { "Sigla": "PR" },
            { "Sigla": "RJ" },
            { "Sigla": "RN" },
            { "Sigla": "RO" },
            { "Sigla": "RR" },
            { "Sigla": "RS" },
            { "Sigla": "SC" },
            { "Sigla": "SE" },
            { "Sigla": "SP" },
            { "Sigla": "TO" }
         ];
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad PerfilPage');
  }  

  getAtualizaUsuario(){
    console.log("Mudando os dados para: " + this.id.value + ', ' + this.nome.value + ", " + this.email.value + ", " + this.senha.value + ", " + this.crm.value);
    this.usuariosProvider.getAtualizaUsuario(this.id.value, this.nome.value, this.email.value, this.nick.value, this.senha.value, this.uf.value+'-'+this.crm.value)
      .then((result:any) => {
        this.presentToast("Dados atualizados com sucesso!");
      })
      .catch((error:any) => {
        this.presentToast("Ops! Erro ao atualizar informações, tente novamente!");
      });
  }

  // exibe mensagem
  presentToast(msg:string){
    const toast = this.toastCtrl.create({
      message: msg,
      duration: 3000,
      position: 'top'
    });

    toast.present();
  }

}
