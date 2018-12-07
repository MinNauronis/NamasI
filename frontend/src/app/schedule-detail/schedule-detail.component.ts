import {Component, Input, OnInit} from '@angular/core';
import {Schedule} from "../objects/schedule";
import {Day} from "../objects/day";
import {DayService} from "../services/day.service";

@Component({
    selector: 'app-schedule-detail',
    templateUrl: './schedule-detail.component.html',
    styleUrls: ['./schedule-detail.component.css']
})
export class ScheduleDetailComponent implements OnInit {

    @Input() schedule: Schedule;

    days: Day[];
    modeInfo: string = 'Laikas nuostatomas pagal paros (laikrodžio) arba saulės laidos/tekmės laiką. ' +
        'Saulė teka 8h. Nustačius +5min, užuolaidos bus atitraukos 8:05';

    constructor(private _dayService: DayService) {

    }

    ngOnInit() {
        this.getDays();
    }

    private getDays() {
        this._dayService.getDays(this.schedule.id).subscribe(
            fetchedDays => this.days = fetchedDays
        )
    }
}
