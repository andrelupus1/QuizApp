import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

/*
  Generated class for the QuestoesProvider provider.

  See https://angular.io/guide/dependency-injection for more info on providers
  and Angular DI.
*/
@Injectable()
export class QuestoesProvider {

  private API_URL = 'http://localhost/web/emailteste/api/questoes/';

  constructor(public http: HttpClient) {
    console.log('Hello QuestoesProvider Provider');
  }
  // retorna todas as questões resolvidas pelo usuário
  getTodasQuestoes(idUsuario:number){

    return new Promise((resolve, reject) => {
      var data = {
        idUsuario: idUsuario
      }
      this.http.post(this.API_URL + 'getQuestoesUsuario', data)
        .subscribe((result:any) => {
          resolve(result);
        },
        (error) => {
          reject(error.error);
        });
    });
  }

  // retorna media de repetição de questões
  getQuestoesRepetidas(idUsuario:number){
    return new Promise((resolve, reject) => {
      var data = {
        idUsuario: idUsuario
      }
      this.http.post(this.API_URL + 'getQuestoesRepetidas', data)
        .subscribe((result:any) => {
          resolve(result);
        },
        (error) => {
          reject(error.error);
        }
      );
    });
  }
}