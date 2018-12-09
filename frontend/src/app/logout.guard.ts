import {Injectable} from '@angular/core';
import {CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, Router} from '@angular/router';
import {Observable} from 'rxjs';
import {SecurityService} from "./services/security.service";

@Injectable({
    providedIn: 'root'
})
export class LogoutGuard implements CanActivate {

    constructor(private _securityService: SecurityService, private _router: Router) {
    }

    canActivate(
        next: ActivatedRouteSnapshot,
        state: RouterStateSnapshot): Observable<boolean> | Promise<boolean> | boolean {
        if (this._securityService.isLogin()) {
            this._router.navigateByUrl('/');
            return false;
        }
        return true;
    }
}
