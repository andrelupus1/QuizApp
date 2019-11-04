import { BrowserModule } from '@angular/platform-browser';
import { ErrorHandler, NgModule } from '@angular/core';
import { IonicApp, IonicErrorHandler, IonicModule } from 'ionic-angular';

import { MyApp } from './app.component';
import { HomePage } from '../pages/home/home';

import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';
import { CadastroPage } from '../pages/cadastro/cadastro';
import { RecuperaPage } from '../pages/recupera/recupera';
import { LoginPage } from '../pages/login/login';
import { GeraProvaPage } from '../pages/gera-prova/gera-prova';
import { EstatisticaPage } from '../pages/estatistica/estatistica';
import { PerfilPage } from '../pages/perfil/perfil';
import { ProvaPage } from '../pages/prova/prova';
import { RankingPage } from '../pages/ranking/ranking';
import { SobrePage } from '../pages/sobre/sobre';
import { ListaProvasPage } from '../pages/lista-provas/lista-provas';
import { UsuariosProvider } from '../providers/usuarios/usuarios';
import { HttpClientModule } from '@angular/common/http';
import { ConfigProvider } from '../providers/config/config';
import { QuestoesProvider } from '../providers/questoes/questoes';
import { ProvasProvider } from '../providers/provas/provas';
import { BannerProvider } from '../providers/banner/banner';
//import { FilterTemasPipe } from '../pipes/filter-temas/filter-temas';
import { TemasPage } from '../pages/temas/temas';
import { DisciplinasProvider } from '../providers/disciplinas/disciplinas';
import { ResumoProvaPage } from '../pages/resumo-prova/resumo-prova';
import { TermosPage } from '../pages/termos/termos';
import { IonicImageViewerModule } from 'ionic-img-viewer';


@NgModule({
  declarations: [
    MyApp, 
    HomePage,
    CadastroPage,
    RecuperaPage,
    LoginPage,
    GeraProvaPage,
    EstatisticaPage,
    PerfilPage,
    ListaProvasPage,
    ProvaPage,
    ResumoProvaPage,
    RankingPage,
    SobrePage,
    TemasPage,
    TermosPage,
   // FilterTemasPipe
  ],
  imports: [
    BrowserModule,
    IonicModule.forRoot(MyApp),
    HttpClientModule,
    IonicImageViewerModule
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    HomePage,
    CadastroPage,
    RecuperaPage,
    LoginPage,
    GeraProvaPage,
    EstatisticaPage,
    PerfilPage,
    ProvaPage,
    ResumoProvaPage,
    ListaProvasPage,
    RankingPage,
    SobrePage,
    TemasPage,
    TermosPage
  ],
  providers: [
    StatusBar,
    SplashScreen,
    {provide: ErrorHandler, useClass: IonicErrorHandler},
    UsuariosProvider,
    ConfigProvider,
    QuestoesProvider,
    ProvasProvider,
    BannerProvider,
    DisciplinasProvider,
    BannerProvider
  ]
}) 
export class AppModule {}
