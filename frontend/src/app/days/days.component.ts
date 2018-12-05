import {Component, OnInit, Input} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {DayService} from "../services/day.service";
import {Day} from "../objects/day";
import {Location} from "@angular/common";

@Component({
    selector: 'app-days',
    templateUrl: './days.component.html',
    styleUrls: ['./days.component.css']
})
export class DaysComponent implements OnInit {

    @Input() scheduleId: number;

    public days: Day[];
    public weekdaysName = [
        'Pirmadienis',
        'Antradienis',
        'Trečiadienis',
        'Ketvirtadienis',
        'Penktadienis',
        'Šeštadienis',
        'Sekmadienis'
        ];
    public modeInfo : string = 'Laikas nuostatomas pagal paros (laikrodžio) arba saulės laidos/tekmės laiką. ' +
        'Saulė teka 8h. Nustačius +5min, užuolaidos bus atitraukos 8:05';

    constructor(
        private _route: ActivatedRoute,
        private _dayService: DayService,
        private _location: Location
    ) {
    }

    ngOnInit() {
        this.getDays();
    }

    private getDays() {
        this._dayService.getDays(this.scheduleId).subscribe(
            fetchedDays => this.days = fetchedDays
        )
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
        if (currentMode === 'sun') {
            day.mode = 'time';
        } else {
            day.mode = 'sun';
        }
    }
}
