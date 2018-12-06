import {Injectable} from '@angular/core';
import {CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot} from '@angular/router';
import {Observable} from 'rxjs';
import {SecurityService} from "./services/security.service";

@Injectable({
  providedIn: 'root'
})
export class LoginGuard implements CanActivate {

  constructor(private _securityService: SecurityService) {
  }

  canActivate() {
    console.log('LoginGuard is making check');
    if(this._securityService.isLogin()){
      return true;
    }

    window.alert('Prašome prisijungti');
    return false;
  }
}
