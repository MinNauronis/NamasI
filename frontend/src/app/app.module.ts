import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {AppComponent} from './app.component';
import {AppRoutingModule} from './app-routing.module';
import {LocationStrategy, HashLocationStrategy} from "@angular/common";
import {HttpClientModule} from "@angular/common/http";
import {CurtainsComponent} from './curtains/curtains.component';
import {NavigationComponent} from './navigation/navigation.component';
import {ScheduleDetailComponent} from './schedule-detail/schedule-detail.component';
import {SchedulesComponent} from './schedules/schedules.component';
import {BrowserAnimationsModule} from "@angular/platform-browser/animations";
import { AppMaterialModule } from './app-material.module';
import { CurtainDetailComponent } from './curtain-detail/curtain-detail.component';
import { DaysComponent } from './days/days.component';
import { LoginComponent } from './security/login/login.component';
import { CreateComponent } from './security/create/create.component';
import { ScheduleNewComponent } from './schedule-new/schedule-new.component';

@NgModule({
    declarations: [
        AppComponent,
        CurtainsComponent,
        NavigationComponent,
        ScheduleDetailComponent,
        SchedulesComponent,
        CurtainDetailComponent,
        DaysComponent,
        LoginComponent,
        CreateComponent,
        ScheduleNewComponent,
    ],
    imports: [
        BrowserModule,
        FormsModule,
        ReactiveFormsModule,
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
