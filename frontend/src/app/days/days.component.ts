import {Component, OnInit, Input, OnDestroy} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {DayService} from "../services/day.service";
import {Day} from "../objects/day";
import {Location} from "@angular/common";
import {FormBuilder, FormGroup, FormControl} from '@angular/forms';

@Component({
    selector: 'app-days',
    templateUrl: './days.component.html',
    styleUrls: ['./days.component.css']
})
export class DaysComponent implements OnInit, OnDestroy {

    @Input() scheduleId: number;
    @Input() day: Day;

    form: FormGroup;
    isUpdating = false;
    isTouched = false;
    weekdaysName = [
        'Pirmadienis',
        'Antradienis',
        'Trečiadienis',
        'Ketvirtadienis',
        'Penktadienis',
        'Šeštadienis',
        'Sekmadienis'
    ];
    modeInfo: string = 'Laikas nuostatomas pagal paros (laikrodžio) arba saulės laidos/tekmės laiką. ' +
        'Saulė teka 8h. Nustačius +5min, užuolaidos bus atitraukos 8:05';

    constructor(
        private _route: ActivatedRoute,
        private _dayService: DayService,
        private _location: Location,
    ) {
    }

    ngOnInit() {
    }

    ngOnDestroy(): void {
        this.onSubmit();
    }

    public update(day: Day) {
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
                break;
            }
            case 'time': {
                day.mode = 'skip';
                break;
            }
            case 'skip': {
                day.mode = 'sun';
                break;
            }
            default: {
                break;
            }
        }
    }

    public onSubmit(): void {
        if (this.isTouched) {
            this._dayService.updateDay(this.scheduleId, this.day).subscribe(
                response => console.log(response)
            )
        }
    }

    public onReset(dayProperty: string) {
        if (this.day[dayProperty]) {
            this.day[dayProperty] = null;
        }
    }

    public onTouch():void {
        this.isTouched = true;
    }

    public isTimeDisable(): boolean{
        if (this.day.mode === 'skip') {
            return true;
        }

        return false;
    }

}
