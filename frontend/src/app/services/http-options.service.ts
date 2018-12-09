import { Injectable } from '@angular/core';
import {HttpHeaders} from '@angular/common/http';
import {SecurityService} from "./security.service";

@Injectable({
  providedIn: 'root'
})
export class HttpOptionsService {

  constructor() { }

  getHttpOptions() {
    return {headers : this.getHeaders()};
  }

  private getHeaders() : HttpHeaders{
    let token =this.getToken();
    if(token) {
      return new HttpHeaders({
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization' : token,
      });
    }

    return new HttpHeaders({
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    });
  }

  private getToken() {
    return localStorage.getItem('accessToken');
  }
}
