import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable()
export class BannerProvider {
  private API_URL = 'http://localhost/web/emailteste/api/banner/';
  constructor(public http: HttpClient) {
    console.log('Hello BannerProvider Provider');
  }

getBanner(){

  return new Promise((resolve, reject) => {

    this.http.get(this.API_URL + 'getBanner')
      .subscribe((result:any) => {
        resolve(result);
      },
      (error) => {
        reject(error.error);
      });

  });
}

}
