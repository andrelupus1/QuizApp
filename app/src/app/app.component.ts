import { Component, ViewChild } from '@angular/core';
import { Nav, Platform } from 'ionic-angular';
import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';

import { HomePage } from '../pages/home/home';
import { LoginPage } from '../pages/login/login';
import { GeraProvaPage } from '../pages/gera-prova/gera-prova';
import { RankingPage } from '../pages/ranking/ranking';
import { PerfilPage } from '../pages/perfil/perfil';
import { SobrePage } from '../pages/sobre/sobre';
import { EstatisticaPage } from '../pages/estatistica/estatistica';
import { ListaProvasPage } from '../pages/lista-provas/lista-provas';
import { TermosPage } from '../pages/termos/termos';

import { ConfigProvider } from '../providers/config/config';
import { ToastController } from 'ionic-angular/components/toast/toast-controller';
import { MenuController } from 'ionic-angular/components/app/menu-controller';

@Component({
  templateUrl: 'app.html',
  providers: [
    ConfigProvider
  ]
})
export class MyApp {
  @ViewChild(Nav) nav: Nav;

  //rootPage: any = LoginPage;
  rootPage:any;

  pages: Array<{title: string, component: any, icone: any}>;

  constructor(
      public platform: Platform, 
      public statusBar: StatusBar, 
      public splashScreen: SplashScreen,
      public toastCtrl: ToastController,
      public menuCtrl: MenuController,
      private configProfiver: ConfigProvider
    ) {
    
      this.platform.ready().then(() => {
        // verifica se a sessão ja esta ativa no localstorage
        let cnf = this.configProfiver.getConfigData();
        let config = JSON.parse(cnf);

        console.log(config); 
  
        if(config == null){
          this.rootPage = LoginPage;
        }else{
          this.rootPage = HomePage;
        }
  
        // Okay, so the platform is ready and our plugins are available.
        // Here you can do any higher level native things you might need.
        this.statusBar.styleDefault();
        this.splashScreen.hide();
      });

      // used for an example of ngFor and navigation
      this.pages = [
        { title: 'Home', component: HomePage, icone: 'ios-home-outline' },
        { title: 'Gerar Prova', component: GeraProvaPage, icone: 'ios-list-box-outline' },
        { title: 'Provas Realizadas', component: ListaProvasPage, icone: 'ios-list-outline' },
        { title: 'Ranking', component: RankingPage, icone: 'ios-trophy-outline' },
        { title: 'Desempenho', component: EstatisticaPage, icone: 'ios-trending-up-outline' },
        { title: 'Meu Perfil', component: PerfilPage, icone: 'ios-contact-outline' },
        { title: 'Sobre', component: SobrePage, icone: 'ios-information-circle-outline' },
        { title: 'Termos de Uso', component: TermosPage, icone: 'ios-bookmarks-outline'}
      ];

  }

  getLogout(){
    console.log('sair');
    this.menuCtrl.close();
    this.presentToast("Obrigado por usar nosso APP!");    
    localStorage.clear();
    this.nav.setRoot(LoginPage);
  }

  openPage(page) {
    // Reset the content nav to have just this page
    // we wouldn't want the back button to show in this scenario
    this.nav.setRoot(page.component);
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
