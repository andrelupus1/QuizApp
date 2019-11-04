import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable()
export class DisciplinasProvider {

  private API_URL = 'http://localhost/web/emailteste/api/provas/';
  constructor(public http: HttpClient) {
    console.log('Hello DisciplinasProvider Provider');
  }

  // lista disciplinas
  getDisciplinas(){
    return new Promise((resolve, reject) => {
      this.http.get(this.API_URL + 'getDisciplinas')
                .subscribe((result:any) => {
                  resolve(result)
                },
                (error) => {
                  reject(error.error)
                }
              )
    })
  }

  // lista disciplinas utilizadas em questões
  getDisciplinasQuestoes(idUsuario:number){
    return new Promise((resolve, reject) => {
      var data = {
        idUsuario: idUsuario
      }

      this.http.post(this.API_URL + 'getDisciplinasQuestoes', data)
        .subscribe((result:any) => {
          resolve(result)
        },
        (error) => {
          reject(error)
        });
    }); 
  }
}