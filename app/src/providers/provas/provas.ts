import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { ConfigProvider } from '../config/config';

/*
  Generated class for the ProvasProvider provider.

  See https://angular.io/guide/dependency-injection for more info on providers
  and Angular DI.
*/
@Injectable()
export class ProvasProvider {
  private API_URL = 'http://localhost/web/emailteste/api/provas/';
  private idUser:number;
  constructor(
      public http: HttpClient,
      private configProvider: ConfigProvider
    ) {
    console.log('Hello ProvasProvider Provider');
    this.getTemasProva();

    // resgata dados do localstorage para o usário
    // carrega dados do usuário via localStorage
    let u = this.configProvider.getConfigData();
    let usuario = JSON.parse(u);
    this.idUser = usuario.id;
  }
/*******************************************************************
 * PROVAS
 ******************************************************************/    
  // lista provas
  getProvas(idUsuario:number){
    return new Promise((resolve, reject) => {

      var data = {
        idUsuario: idUsuario
      }

      this.http.post(this.API_URL + 'getProvas', data)
        .subscribe((result:any) => {
          resolve(result);
        },
        (error) => {
          reject(error.error);
        });
    });
  }

  // geraProvas
  geraProvas(tipoProva:any, qtdeQuestoes: any, disciplinas:Array<any>){//retirando qtdeQuestoes:any
    return new Promise((resolve, reject) => {
      var data = {
        idUser: this.idUser,
        tipoProva: tipoProva,
        qtdeQuestoes: qtdeQuestoes,
        disciplinas: disciplinas
      }

      console.log(data);

      this.http.post(this.API_URL + 'geraProva', data)
          .subscribe((result:any) => {
            resolve(result);
          },
          (error) => {
            reject(error.error);
          })
    });
  }

  // abre a prova
  getProvaId(id:number){
    return new Promise((resolve, reject) => {
      var data = {
        idUser: this.idUser,
        idProva: id
      }

      this.http.post(this.API_URL + 'getProvaId', data)
        .subscribe((result:any) => {
          resolve(result);
        },
        (error) => {
          reject(error.error);
        }
      );
    });
  }

  // salva resposta correta
  getResposta(idAvaliacao:number, idQuestao:number, idAlt:number){
    return new Promise((resolve, reject) => {
      var data = {
        idAvaliacao: idAvaliacao,
        idQuestao: idQuestao,
        idAlt: idAlt
      }

      this.http.post(this.API_URL + 'getResposta', data)
        .subscribe((result:any) => {
          resolve(result);
        },
        (error) => {
          reject(error.error);
        }
      );
    });
  }

  // salva questão como favorita
  getSalvaFavorita(idQuestao:number, status:number){
    return new Promise((resolve, reject) => {
      var data = {
        idQuestao: idQuestao,
        status: status
      }

      this.http.post(this.API_URL + 'getFavorita', data)
        .subscribe((result:any) => {
          resolve(result);
        },
        (error) => {
          reject(error.error);
        }
      );
    });
  }
/*******************************************************************
 * TIPOS DE PROVAS
 * ****************************************************************/  
  // retorna tipos de provas
  getTipoProva(){
    return new Promise((resolve, reject) => {

      this.http.get(this.API_URL + 'getTipoProva')
        .subscribe((result:any) => {
          resolve(result);
        },
        (error) => {
          reject(error.error);
        });
    });
  }

  // lista media de tipos de provas realizadas
  getMediaTipoProva(idUsuario:number){
    return new Promise((resolve, reject) => {
      var data = {
        idUsuario: idUsuario
      }

      this.http.post(this.API_URL + 'getMediaTipoProva', data)
        .subscribe((result:any) => {
          resolve(result);
        },
        (error) => {
          reject(error.error);
        });
    });
  }

/******************************************************************
 * TEMAS E SUBTEMAS  
 * ***************************************************************/
  // retorna temas
  getTemasProva(){

    return new Promise((resolve, reject) => {

      this.http.get(this.API_URL + 'getTemas')
        .subscribe((result:any) => {
          resolve(result);
        },
        (error) => {
          reject(error.error);
        });

    });


  }
/******************************************************************
 * RANCKING
 * ***************************************************************/
  getRanking(){
    return new Promise((resolve, reject) => {
      this.http.get(this.API_URL + 'getRanking')
        .subscribe((result:any) => {
          resolve(result);
        },
        (error) => {
          reject(error.error);
        });
    });
  }
}
