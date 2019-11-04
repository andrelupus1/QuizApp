import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

let config_key_name = "config";

@Injectable()
export class ConfigProvider {
  /*
  private config = {
    id: "",
    nome: "",
    email: "",
    crm: "",
    loginUser: false
  }*/

  constructor(public http: HttpClient) {
  }

  // recupera os dados do local storage
  getConfigData():any{
    return localStorage.getItem(config_key_name);
  }

  // grava os dados no local storage
  setConfigData(id?:number, nome?:string, email?:string, nick?:string, crm?:string, loginUser?:boolean){

    let config = {
      id,
      nome: "",
      email: "",
      nick:"",
      crm: "",
      loginUser: true
    }

    if(id){
      config.id = id;
    }

    if(nome){
      config.nome = nome;
    }

    if(email){
      config.email = email;
    }

    if(nick){
      config.nick = nick;
    }

    if(crm){
      config.crm = crm;
    }

    if(loginUser){
      config.loginUser = loginUser;
    }

    localStorage.setItem(config_key_name, JSON.stringify(config));



  }


}
