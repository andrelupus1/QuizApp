import { Component, ViewChild } from '@angular/core';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { ProvaPage } from '../prova/prova';
import { TemasPage } from '../temas/temas';
import { ProvasProvider } from '../../providers/provas/provas';
import { LoadingController } from 'ionic-angular/components/loading/loading-controller';
import { DisciplinasProvider } from '../../providers/disciplinas/disciplinas';
import { StatusBar } from '@ionic-native/status-bar';

/**
 * Generated class for the GeraProvaPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-gera-prova',
  templateUrl: 'gera-prova.html',
  providers: [
    ProvasProvider
  ]
})
export class GeraProvaPage {
  termoFiltro:any;
  listaTipo:Array<any>;
  listaTema:Array<any>;
  disciplinas:Array<any>;
  disciplinasSelecionadas: Array<any>[];

  // recebe parametros do formulário
  @ViewChild('tipo') tipo;
  @ViewChild('qtde') qtde;
  @ViewChild('slcDisc') slcDisc;

  constructor(
      public navCtrl: NavController, 
      public navParams: NavParams,
      private statusBar: StatusBar,
      public loadingCtrl: LoadingController,
      private provasProvider: ProvasProvider,
      private disciplinasProvider: DisciplinasProvider
    ) {
      // let status bar overlay webview 
      this.statusBar.overlaysWebView(false);
      // set status bar to white
      this.statusBar.backgroundColorByHexString('#09a266');
      this.disciplinasSelecionadas = [];

      this.getLoader();
      // tipo de prova
      this.getTipoProva();
      // lista disciplinas
      this.getDisciplinas();
     
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad GeraProvaPage');
  }

  getProva(){
    console.log('GERANDO PROVA');
    console.log('===================================');
    console.log('Tipo: ');
    console.log(this.tipo.value.length);
    console.log('===================================');
    console.log('Qtde: ');
    console.log(this.qtde.length);   
    console.log('===================================');
    console.log('Disciplinas: ');
    console.log(this.disciplinasSelecionadas.length);   
    // verifica se o tipo de prova foi passado
    if(this.tipo.value.length == 0){
      alert("Você deve selecionar um Tipo de Prova!");
      return false;
    }else{
      this.getLoader();
      this.provasProvider.geraProvas(this.tipo.value, this.qtde.value, this.disciplinasSelecionadas)
        .then((result:any) => {
          console.log('Sucesso: ');
          console.log(result.dados);
          if(result.dados.status_conexao == '1'){
            this.navCtrl.push(ProvaPage, {id: result.dados.idAvaliacao});
          }
          if(result.dados.status_conexao == '2'){
            alert('A(s) Disciplina(s) que você selecionou, não possuem questões suficientes para montar esta avaliação, por favor selecione mais algumas ou deixe as mesmas desselecionadas.');
            return false;
          }
          if(result.dados.status_conexao == '0'){
            alert('Ops! Houve um erro, por favor tente novamente!');
            return false;
          }
        })
        .catch((error:any) => {
          console.log('Error: ');
          console.log(error);
        });
    }
  }
// coleta disciplinas
  slcDisciplina(id){

    //var dados = {idDisc: disciplina};

    // busca item na lista para saber se existe ou não
    let search = this.disciplinasSelecionadas.indexOf(id);

    console.log(search);
    if(search === -1){
      // adiciona item
      // verifica se o item ja esta adicionado no vetor
      this.disciplinasSelecionadas.push(id);
    }else{
      this.disciplinasSelecionadas.splice(search, 1);
    }

    console.log(this.disciplinasSelecionadas);
  }

// lista tipos de questões
  getTipoProva(){
    this.provasProvider.getTipoProva()
      .then((result:any) => {
          this.listaTipo = result.dados;
          console.log(this.listaTipo);
          return this.listaTipo;
      })
      .catch((error:any) => {
          console.log(error);
      });
  }
// lista disciplinas
  getDisciplinas(){
    this.disciplinasProvider.getDisciplinas()
      .then((result:any) => {
        this.disciplinas = result.dados;
        console.log(this.disciplinas);
        return this.disciplinas;
      })
  }
// lista subtemas
  getTema(){
    this.navCtrl.push(TemasPage);
  }
// adiciona disciplina a lista local
  selectItem(item:any){
    console.log('Item a ser adicionado');
    console.log(item);
  }
  getLoader() {
    let loader = this.loadingCtrl.create({
      content: "Aguarde carregando...",
      duration: 1200
    });
    loader.present();
  }
}