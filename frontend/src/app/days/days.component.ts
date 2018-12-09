import {Component, OnInit, Input} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {DayService} from "../services/day.service";
import {Day} from "../objects/day";
import {Location} from "@angular/common";
import {Subject} from 'rxjs';
import {debounceTime, switchMap} from 'rxjs/operators';

@Component({
    selector: 'app-days',
    templateUrl: './days.component.html',
    styleUrls: ['./days.component.css']
})
export class DaysComponent implements OnInit {

    @Input() scheduleId: number;
    @Input() day: Day;

    updateDay = new Subject<any>();
    weekdaysName = [
        'Pirmadienis',
        'Antradienis',
        'Trečiadienis',
        'Ketvirtadienis',
        'Penktadienis',
        'Šeštadienis',
        'Sekmadienis'
    ];

    constructor(
        private _route: ActivatedRoute,
        private _dayService: DayService,
        private _location: Location,
    ) {
    }

    ngOnInit() {
        this.updateDay.pipe(
            debounceTime(1200),
            switchMap(_ => this._dayService.updateDay(this.scheduleId, this.day))
        ).subscribe(response => console.log(response));
    }
    /**
     * weekday 1-7
     * @param weekday
     */
    public getDayTitle(weekday: number): string {
        if (weekday == null) {
            return '';
        }

        if (weekday > 0 && 8 > weekday) {
            return this.weekdaysName[weekday - 1];
        }

        return '';
    }

    public onChangeMode(day: Day): void {
        let currentMode = day.mode;
        switch (currentMode) {
            case 'sun': {
                day.mode = 'time';
                this.updateDay.next('time');
                break;
            }
            case 'time': {
                day.mode = 'skip';
                this.updateDay.next('skip');
                break;
            }
            case 'skip': {
                day.mode = 'sun';
                this.updateDay.next('sun');
                break;
            }
            default: {
                break;
            }
        }
    }

    public onTimeChange():void {
        this.updateDay.next('time changed');
    }

    public isTimeDisable(): boolean{
        if (this.day.mode === 'skip') {
            return true;
        }

        return false;
    }

}
