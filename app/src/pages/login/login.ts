import { Component, ViewChild } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { ToastController } from 'ionic-angular/components/toast/toast-controller';

import { HomePage } from '../home/home';

import { UsuariosProvider } from '../../providers/usuarios/usuarios';
import { CadastroPage } from '../cadastro/cadastro';
import { RecuperaPage} from '../recupera/recupera';
import { StatusBar } from '@ionic-native/status-bar';

@IonicPage()
@Component({
  selector: 'page-login',
  templateUrl: 'login.html',
  providers: [
    UsuariosProvider
  ]
})
export class LoginPage {
  // recebe parametros do formulário de login
  @ViewChild('usuario') usuario;
  @ViewChild('senha') senha;

  constructor(
    public navCtrl: NavController, 
    public navParams: NavParams,
    public toastCtrl: ToastController,
    private statusBar: StatusBar,
    private usuariosProvider: UsuariosProvider
  ) {
    // let status bar overlay webview 
    this.statusBar.overlaysWebView(false);
    // set status bar to white
    this.statusBar.backgroundColorByHexString('#09a266');
  }
  // método de login
  getLogin(){
    console.log("Fazendo Login com o usuario: " + this.usuario.value + " e a senha: " + this.senha.value);
    this.usuariosProvider.getLoginUser(this.usuario.value, this.senha.value)
      .then((result:any) => {
          console.log('***********************************');
          console.log(result);
          if(result.loginUsuario == true){
            this.presentToast('Olá ' + result.usuario_nome + ', seja Bem-vindo(a) ao QuizApp!');
            // aqui tem que add o providers de config
            this.navCtrl.setRoot(HomePage);
          }else{
            this.presentToast('Usuário ou senha inválidos, tente novamente!');
          }
      })
      .catch((error:any) => {
          console.log(error);
          this.presentToast('Usuário ou senha Incorretos!');
      });


  }

  // método de chamada de cadastro
  getCadastro(){
    this.navCtrl.push(CadastroPage);
  }
  getRecupera(){
    this.navCtrl.push(RecuperaPage);
  }

  // exibe mensagem
  presentToast(msg:string){
    const toast = this.toastCtrl.create({
      message: msg,
      duration: 6000,
      position: 'top'
    });

    toast.present();
  }

}
