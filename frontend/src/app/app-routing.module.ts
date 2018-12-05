import {NgModule} from '@angular/core';
import {Routes, RouterModule} from "@angular/router";
import {HeroesComponent} from "./heroes/heroes.component";
import {HeroDetailComponent} from "./hero-detail/hero-detail.component";
import {DashboardComponent} from "./dashboard/dashboard.component";
import {CurtainsComponent} from "./curtains/curtains.component";
import {SchedulesComponent} from "./schedules/schedules.component";
import {CurtainDetailComponent} from "./curtain-detail/curtain-detail.component";

const routes: Routes = [
    {path: '', redirectTo: '/curtains', pathMatch: 'full'},
    {path: 'heroes', component: HeroesComponent},
    {path: 'dashboard', component: DashboardComponent},
    {path: 'hero/:id', component: HeroDetailComponent},
    {path: 'curtains', component: CurtainsComponent},
    {path: 'curtains/:id', component: CurtainDetailComponent},
    {path: 'schedules/:id', component: SchedulesComponent}
]

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
})

export class AppRoutingModule {
}

