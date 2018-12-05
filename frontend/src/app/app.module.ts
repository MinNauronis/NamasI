import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {FormsModule} from "@angular/forms";
import {AppComponent} from './app.component';
import {HeroesComponent} from './heroes/heroes.component';
import {HeroDetailComponent} from './hero-detail/hero-detail.component';
import {MessageComponent} from './message/message.component';
import {AppRoutingModule} from './app-routing.module';
import {LocationStrategy, HashLocationStrategy} from "@angular/common";
import {DashboardComponent} from './dashboard/dashboard.component';
import {HttpClientModule} from "@angular/common/http";
import {HeroSearchComponent} from './hero-search/hero-search.component';
import {CurtainsComponent} from './curtains/curtains.component';
import {NavigationComponent} from './navigation/navigation.component';
import {ScheduleDetailComponent} from './schedule-detail/schedule-detail.component';
import {SchedulesComponent} from './schedules/schedules.component';
import {BrowserAnimationsModule} from "@angular/platform-browser/animations";
import { AppMaterialModule } from './app-material.module';
import { CurtainDetailComponent } from './curtain-detail/curtain-detail.component';
import { DaysComponent } from './days/days.component';

@NgModule({
    declarations: [
        AppComponent,
        HeroesComponent,
        HeroDetailComponent,
        MessageComponent,
        DashboardComponent,
        HeroSearchComponent,
        CurtainsComponent,
        NavigationComponent,
        ScheduleDetailComponent,
        SchedulesComponent,
        CurtainDetailComponent,
        DaysComponent
    ],
    imports: [
        BrowserModule,
        FormsModule,
        AppRoutingModule,
        HttpClientModule,
        BrowserAnimationsModule,
        AppMaterialModule,
],
    providers: [
        {provide: LocationStrategy, useClass: HashLocationStrategy}
    ],
    bootstrap: [AppComponent]
})

export class AppModule {
}
