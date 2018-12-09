import {Injectable} from '@angular/core';
import {CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, Router} from '@angular/router';
import {Observable} from 'rxjs';
import {SecurityService} from "./services/security.service";

@Injectable({
  providedIn: 'root'
})
export class LoginGuard implements CanActivate {

  constructor(private _securityService: SecurityService, private _router: Router) {
  }

  canActivate() {
    console.log('LoginGuard is making check');
    if(this._securityService.isLogin()){
      return true;
    }

    this._router.navigateByUrl('login')
    return false;
  }
}
