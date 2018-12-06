import {NgModule} from '@angular/core';
import {Routes, RouterModule} from "@angular/router";
import {HeroesComponent} from "./heroes/heroes.component";
import {HeroDetailComponent} from "./hero-detail/hero-detail.component";
import {DashboardComponent} from "./dashboard/dashboard.component";
import {CurtainsComponent} from "./curtains/curtains.component";
import {SchedulesComponent} from "./schedules/schedules.component";
import {CurtainDetailComponent} from "./curtain-detail/curtain-detail.component";
import {CreateComponent} from "./security/create/create.component";
import {LoginComponent} from "./security/login/login.component";
import {LoginGuard} from "./login-guard.service";

const routes: Routes = [
    {path: '', redirectTo: '/curtains', pathMatch: 'full'},
    {path: 'heroes', component: HeroesComponent, canActivate: [LoginGuard]},
    {path: 'dashboard', component: DashboardComponent, canActivate: [LoginGuard]},
    {path: 'hero/:id', component: HeroDetailComponent, canActivate: [LoginGuard]},
    {path: 'curtains', component: CurtainsComponent, canActivate: [LoginGuard]},
    {path: 'curtains/:id', component: CurtainDetailComponent, canActivate: [LoginGuard]},
    {path: 'schedules/:id', component: SchedulesComponent, canActivate: [LoginGuard]},
    {path: 'registration', component: CreateComponent},
    {path: 'login', component: LoginComponent}
]

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
})

export class AppRoutingModule {
}

