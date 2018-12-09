import {NgModule} from '@angular/core';
import {Routes, RouterModule} from "@angular/router";
import {CurtainsComponent} from "./curtains/curtains.component";
import {SchedulesComponent} from "./schedules/schedules.component";
import {CurtainDetailComponent} from "./curtain-detail/curtain-detail.component";
import {CreateComponent} from "./security/create/create.component";
import {LoginComponent} from "./security/login/login.component";
import {LoginGuard} from "./login-guard.service";
import {LogoutGuard} from "./logout.guard";

const routes: Routes = [
    {path: '', redirectTo: '/curtains', pathMatch: 'full'},
    {path: 'curtains', component: CurtainsComponent, canActivate: [LoginGuard]},
    {path: 'curtains/:id', component: CurtainDetailComponent, canActivate: [LoginGuard]},
    {path: 'schedules/:id', component: SchedulesComponent, canActivate: [LoginGuard]},
    {path: 'registration', component: CreateComponent, canActivate: [LogoutGuard]},
    {path: 'login', component: LoginComponent, canActivate: [LogoutGuard]}
]

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
})

export class AppRoutingModule {
}

