import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Platform } from 'ionic-angular';
import { ConfigProvider } from '../config/config';

/*
  Generated class for the UsuariosProvider provider.

  See https://angular.io/guide/dependency-injection for more info on providers
  and Angular DI.
*/
//let config_key_user = 'user';

@Injectable()
export class UsuariosProvider {

 private API_URL = 'http://localhost/web/emailteste/api/usuarios/';//SERVIDOR (1 de 2)
  /*
  private user = {
    idusuario: "",
    nome:"",
    email:"",
    crm:"",
    status:"",
    tipo:""
  }*/

  constructor(
    public http: HttpClient,
    private _platform: Platform,
    private configProvider: ConfigProvider
  ) {
    // verifica em qual plataforma esta sendo aberto o app para redirecionamento de url de acesso
    // este comando evita erros de cabeçalhos
    if(this._platform.is("cordova")){
      this.API_URL = 'http://localhost/web/emailteste/api/usuarios/';//SERVIDOR(2 de 2)
    }
    //console.log(this._platform.resume);
  }
  
  // cadastra novo usuario
  getCadastraUsuario(nome:string, email:string, nick:string, senha:string, crm:string){
    return new Promise((resolve, reject) => {
      var data = {
        nome: nome,
        email: email,  
        nick:nick, 
        senha: senha,             
        crm: crm
      }
      //console.log("dados de cadastro: ");
      //console.log(data);

      this.http.post(this.API_URL + 'addUsuario', data)
        .subscribe((result:any) => {
          resolve(result);
        },
        (error) => {
          reject(error.error);
        });

    });
  }
  getRecupera(email:string){
    return new Promise((resolve, reject) => {
      var data = {
        email: email
      }
      //console.log("dados de Recupera Senha: ");
      //console.log(data);

      this.http.post(this.API_URL + 'recuperaSenha', data)
        .subscribe((result:any) => {
          resolve(result);
        },
        (error) => {
          reject(error.error);
        });

    });
  }
  // atualiza novo usuario
  getAtualizaUsuario(id:number, nome:string, email:string, nick:string, senha:string, crm:string){
    
  return new Promise((resolve, reject) => {
    var data = {
      id:id,
      nome: nome,
      email: email,  
      nick:nick, 
      senha: senha,             
      crm: crm
    }
    //console.log("dados de cadastro: ");
    //console.log(data);
    this.http.post(this.API_URL + 'upUsuario', data)
      .subscribe((result:any) => {
        resolve(result);
      },
      (error) => {
        reject(error.error);
      });
  });
}
  // valida acesso de login no app
  getLoginUser(email:string, senha:string){
    return new Promise((resolve, reject) => {
      var data = {
        email: email,
        senha: senha
      }
      this.http.post(this.API_URL + 'login', data)
        .subscribe((result:any) => {
          //console.log(result);
          const dados = result.dados;
          resolve(dados);
          console.log(dados);
          console.log('==================================');
          console.log(result.dados);
          if(dados.loginUsuario == true){
            this.configProvider.setConfigData(
              dados.usuario_id,
              dados.usuario_nome,
              dados.usuario_email,
              dados.usuario_nick,
              dados.usuario_crm,
              dados.loginUsuario
            );
          }

        },
        (error) => {
          reject(error.error);
        });
    });
  }
/*******************************************************************
 * ESTATISTICAS
 ******************************************************************/    
  getAcertoGlobal(idUsuario:number){
    return new Promise((resolve, reject) => {
      var data = {
        idUsuario: idUsuario
      }

      this.http.post(this.API_URL + 'getAcertoGlobal', data)
        .subscribe((result:any) => {
          resolve(result);
        },
        (error) => {
          reject(error);
        });
    });
  }
  // verifica posiçãono ranking
  getPosicaoRanking(idUsuario:number){
    return new Promise((resolve, reject) => {
      var data = {
        idUsuario: idUsuario
      }
      this.http.post(this.API_URL + 'getPosicaoRanking', data)
        .subscribe((result:any) => {
          resolve(result);
        },
        (error) => {
          reject(error);
        });
    });
  }
}