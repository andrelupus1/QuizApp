import { Component,ViewChild} from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { Validators, AbstractControl, FormBuilder, FormGroup} from '@angular/forms';
import { UsuariosProvider } from '../../providers/usuarios/usuarios';
import { ToastController } from 'ionic-angular/components/toast/toast-controller';
import { LoginPage } from '../login/login'; 
import { StatusBar } from '@ionic-native/status-bar';
//import { Component } from '@angular/core';
//import { IonicPage, NavController, NavParams } from 'ionic-angular';

@IonicPage()
@Component({
  selector: 'page-recupera',
  templateUrl: 'recupera.html',
  providers:[
    UsuariosProvider
  ]
})
export class RecuperaPage {
  messageEmail = "";
  errorEmail = false;
  formgroup:FormGroup;
  email:AbstractControl;
  // recebe parametros do formulário
  @ViewChild('email') txtEmail;
  constructor(
    public navCtrl: NavController, 
    public navParams: NavParams,
    public formBuilder: FormBuilder,
    public toastCtrl: ToastController,
    private statusBar: StatusBar,
    private usuariosProvider: UsuariosProvider
  ) {
     //Form
     this.formgroup = formBuilder.group({
      email:['', Validators.compose([Validators.email,Validators.required])],
    });

    // let status bar overlay webview 
    this.statusBar.overlaysWebView(false);
    // set status bar to white
    this.statusBar.backgroundColorByHexString('#09a266');
  }
  recuperaForm(){
    let { email} = this.formgroup.controls;

    if (!this.formgroup.valid) {
      if (!email.valid) {
        this.errorEmail = true;
        this.messageEmail ="O E-mail precisa ser preenchido corretamente!"
      } else {
        this.messageEmail = "";
      }
    }else {
      //Mostra os dados do console que recebeu do AbstractControl
        console.log(
      ' E-mail: ' + this.formgroup.get('email').value);
      //Envia os dados do Fomulário para API
        this.txtEmail = this.formgroup.get('email').value;
        this.usuariosProvider.getRecupera(
        this.txtEmail)
        .then((result:any) => {
        console.log("Retorno: " + result);
      this.presentToast('Senha enviada para e-mail!');
      // aqui tem que add o providers de config
      this.navCtrl.setRoot(LoginPage);
        }).catch((error:any) => {
        console.log(error);
        this.presentToast('Erro ao recuperar senha. Verifique se o e-mail existe!');
        this.navCtrl.setRoot(LoginPage);//Direciona para home.

       });
      } 
    }
    presentToast(msg:string){
      const toast = this.toastCtrl.create({
        message: msg,
        duration: 6000,
        position: 'top'
      });
      toast.present();
    }
  }
/*   ionViewDidLoad() {
    console.log('ionViewDidLoad RecuperaPage');
  } */