import { Component, OnInit } from '@angular/core';
import {SecurityService} from "../services/security.service";
import {Router} from '@angular/router';

@Component({
  selector: 'app-navigation',
  templateUrl: './navigation.component.html',
  styleUrls: ['./navigation.component.css']
})
export class NavigationComponent implements OnInit {

  constructor(private _securityService: SecurityService, private _router: Router) { }

  ngOnInit() {
  }

  onLogout() {
    this._securityService.logoutUser();
    this._router.navigateByUrl('login');
  }

  isLogin() {
    return this._securityService.isLogin();
  }
}
