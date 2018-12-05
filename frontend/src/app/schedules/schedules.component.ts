import {Component, Input, OnInit} from '@angular/core';
import {ScheduleService} from "../services/schedule.service";
import {Schedule} from "../objects/schedule";

@Component({
    selector: 'app-schedules',
    templateUrl: './schedules.component.html',
    styleUrls: ['./schedules.component.css']
})

export class SchedulesComponent implements OnInit {

    @Input() curtainId : number;

    public schedules: Schedule[];
    public selectedSchedule: Schedule;

    constructor(private _scheduleService: ScheduleService) {
    }

    ngOnInit() {
        this.getSchedules();
    }

    getSchedules(): void {
        this._scheduleService.getSchedules(1)
            .subscribe(schedules => this.schedules = schedules);
    }

    onClick(schedule: Schedule) {
        if (this.selectedSchedule === schedule) {
            this.selectedSchedule = null;
        } else {
            this.selectedSchedule = schedule;
        }
    }

}
