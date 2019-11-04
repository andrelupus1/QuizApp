import { Component,ViewChild} from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { Validators, AbstractControl, FormBuilder, FormGroup} from '@angular/forms';
import { UsuariosProvider } from '../../providers/usuarios/usuarios';
import { ToastController } from 'ionic-angular/components/toast/toast-controller';
import { LoginPage } from '../login/login'; 
import { StatusBar } from '@ionic-native/status-bar';
//import { isArray } from 'ionic-angular/util/util';

@IonicPage()
@Component({
  selector: 'page-cadastro',
  templateUrl: 'cadastro.html',
  providers:[
    UsuariosProvider
  ]
})
export class CadastroPage {
  messageNome = "";
  messageEmail = "";
  messageNick = "";
  messageSenha = "";
  errorNome = false;
  errorEmail = false;
  errorNick = false;
  errorSenha = false;
  formgroup:FormGroup;
  nome:AbstractControl;
  email:AbstractControl;
  nick:AbstractControl;
  senha:AbstractControl;
  // recebe parametros do formulário
  @ViewChild('nome') txtNome;
  @ViewChild('email') txtEmail;
  @ViewChild('nick') txtNick;
  @ViewChild('senha') txtSenha;
  @ViewChild('crm') txtCrm;
  @ViewChild('uf') txtUf; 
  estados:Array<any>;
  constructor(
      public navCtrl: NavController, 
      public navParams: NavParams,
      public formBuilder: FormBuilder,
      public toastCtrl: ToastController,
      private statusBar: StatusBar,
      private usuariosProvider: UsuariosProvider //RETORNAR
    ) {
      //Form
      this.formgroup = formBuilder.group({
        nome:['', Validators.compose([Validators.minLength(5),Validators.maxLength(50), Validators.required])],
        email:['', Validators.compose([Validators.email,Validators.required])],
        nick:['', Validators.compose([Validators.required,Validators.minLength(5)])],
        senha:['',Validators.compose([Validators.minLength(6), Validators.maxLength(20),
          Validators.required])],
      });
      
     //form associando variaveis não utilizar
      /* this.nome = this.formgroup.controls['nome'];
      this.email =  this.formgroup.controls['email'];
      this.nick =  this.formgroup.controls['nick'];
      this.senha =  this.formgroup.controls['senha']; */

      // let status bar overlay webview 
      this.statusBar.overlaysWebView(false);
      // set status bar to white
      this.statusBar.backgroundColorByHexString('#09a266');

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
  cadastroForm(){
      let { nome, email, nick, senha} = this.formgroup.controls;
  
      if (!this.formgroup.valid) {
        if (!nome.valid) {
          this.errorNome = true;
          this.messageNome = "O campo nome precisa ser preenchido e ter ter no mínimo 5 caracteres!";
        } else {
          this.messageNome = "";
        }
  
        if (!email.valid) {
          this.errorEmail = true;
          this.messageEmail ="O E-mail precisa ser preenchido corretamente!"
        } else {
          this.messageEmail = "";
        }
        if (!nick.valid) {
          this.errorNick = true;
          this.messageNick ="O Nickname precisa ser preenchido e ter no mínimo 5 caracteres!"
        } else {
          this.messageNick = "";
        }
        if (!senha.valid) {
          this.errorSenha = true;
          this.messageSenha = "A senha precisa ter de 6 a 20 caracteres!"
        } else {
          this.messageSenha = "";
        }
      }else {
        //Mostra os dados do console que recebeu do AbstractControl
          console.log('Cadastrando Usuário Nome: ' +  this.formgroup.get('nome').value+
        ' E-mail: ' + this.formgroup.get('email').value+
        ' Nickname ' +  this.formgroup.get('nick').value+
        ' Senha: ' +  this.formgroup.get('senha').value+
        ' CRM: ' + this.txtUf.value+'-'+this.txtCrm.value);
        //Envia os dados do Fomulário para API
         
          this.txtNome = this.formgroup.get('nome').value;//Pode ser direto, mas deixei recebendo
          this.txtEmail = this.formgroup.get('email').value;
          this.txtNick = this.formgroup.get('nick').value;
          this.txtSenha = this.formgroup.get('senha').value;
         
          this.usuariosProvider.getCadastraUsuario(
          this.txtNome,
          this.txtEmail,
          this.txtNick,
          this.txtSenha,
          this.txtUf.value+'-'+this.txtCrm.value)
          .then((result:any) => {
          console.log("Retorno: " + result);
        this.presentToast('Cadastro Realizado com sucesso! Foi enviado um e-mail para ativar sua conta.');
        // aqui tem que add o providers de config
        this.navCtrl.setRoot(LoginPage);
          }).catch((error:any) => {
          console.log(error);
          this.presentToast('Erro ao realizar cadastro, tente novamente!');
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
    }//fim class cadastro page
  /*
  //Antes de implementar a validação era usado o código abaixo.
  getCadastraUsuario(){
    console.log('Cadastrando Usuário Nome: ' + this.nome.value + ' E-mail: ' + this.email.value + ' Senha: ' + this.senha.value + ' CRM: ' + this.crm.value);
//concatena uf - crm e sobre como CRM.
    this.usuariosProvider.getCadastraUsuario(this.nome.value, this.email.value, this.nick.value, this.senha.value, this.uf.value+'-'+this.crm.value)
    .then((result:any) => {
      console.log("Retorno: " + result);
      this.presentToast('Cadastro Realizado com sucesso! Foi enviado um e-mail para ativar sua conta.');
      // aqui tem que add o providers de config
      this.navCtrl.setRoot(LoginPage);
      
    })
    .catch((error:any) => {
      console.log(error);
      this.presentToast('Erro ao realizar cadastro, tente novamente!');
      this.navCtrl.setRoot(LoginPage);//Direciona para home.

    });
  } */
/*   // exibe mensagem
  presentToast(msg:string){
    const toast = this.toastCtrl.create({
      message: msg,
      duration: 6000,
      position: 'top'
    });
    toast.present();
  }
  } */
 // exibe mensagem
