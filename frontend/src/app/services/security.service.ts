import {Injectable} from '@angular/core';
import {HttpHeaders, HttpClient} from '@angular/common/http';
import {Observable, Subject} from 'rxjs';
import {HttpOptionsService} from "./http-options.service";

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  })
};

@Injectable({
  providedIn: 'root'
})
export class SecurityService {

  private _serverUrl = 'http://localhost:8000/';
  private _registrationUrl = 'api/registration/';
  private _loginUrl = 'oauth/token';
  private _disconnetionUrl = 'api/disconnection/'

  constructor(private _http: HttpClient, private _httpOptionsSercive: HttpOptionsService) {
  }

  public createUser(name: string, email: string, password: string): Observable<any> {
    let body = JSON.stringify({
      name: name,
      email: email,
      password: password
    });
    let url = this._serverUrl + this._registrationUrl;
    return this._http.post(url, body, httpOptions).pipe(

    );
  }

  public loginUser(name: string, password: string) {
    let options = this._httpOptionsSercive.getHttpOptions();
    let body = JSON.stringify({
      username: name,
      password: password,
      grant_type: 'password',
      client_id: 2,
      client_secret: '25PL4LDm4XZ9CL5BNzZtgnOa1fg3ckviexo2hNsW'
    });
    let url = this._serverUrl + this._loginUrl;
    let isAuthorize = new Subject<any>();
    this._http.post(url, body, options).subscribe(
      response => {
        this.setToken(response['access_token']);
        isAuthorize.next(true);
      },
      response => {
        isAuthorize.next(false);
      }
    );

    return isAuthorize;
  }

  public isLogin(): boolean {
    let token = this.getToken();
    if (token) {
      return true;
    }

    return false;
  }

  private setToken(token: string): void {
    localStorage.setItem('accessToken', `Bearer ${token}`);
  }

  public getToken() {
    return localStorage.getItem('accessToken');
  }

  private unsetToken(): void {
    localStorage.removeItem('accessToken');
  }

  public logoutUser() {
    let options = this._httpOptionsSercive.getHttpOptions();
    let url = this._serverUrl + this._disconnetionUrl;
    this._http.post(url, null, options).subscribe(
        response => console.log(response)
    );
    this.unsetToken();
  }
}
