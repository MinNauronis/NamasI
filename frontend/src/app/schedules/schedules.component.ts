import {Component, Input, OnInit} from '@angular/core';
import {ScheduleService} from "../services/schedule.service";
import {Schedule} from "../objects/schedule";

@Component({
    selector: 'app-schedules',
    templateUrl: './schedules.component.html',
    styleUrls: ['./schedules.component.css']
})

export class SchedulesComponent implements OnInit {

    @Input() curtainId: number;
    /**
     * @var defaultId -> curtain.selectedScheduleId
     */
    public defaultId = null;
    public editingId = null;

    public schedules: Schedule[];
    /**
     * @var selectedSchedule Opened schedule
     */
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

    onScheduleSelect(schedule: Schedule) {
        if (this.selectedSchedule === schedule) {
            this.selectedSchedule = null;
        } else {
            this.selectedSchedule = schedule;
        }
    }

    isScheduleSelected(schedule: Schedule) {
        if (schedule === this.selectedSchedule) {
            return true;
        }

        return false;
    }

    isScheduleDefault(schedule: Schedule): boolean {
        if (schedule.id === this.defaultId) {
            return true;
        }

        return;
    }

    onDelete(schedule: Schedule): void {
        console.log('want to delete');
        this.schedules = this.schedules.filter(h => h !== schedule);
        //this._heroService.deleteHero(hero).subscribe();
    }

    /**
     * Set editingId to schedule's witch has to be editable
     * @param schedule
     */
    onEdit(schedule: Schedule): void {
        if (this.editingId != null) {
            //save edit by editingId
        }

        if (schedule.id === this.editingId) {
            this.editingId = null;
            console.log('edit status now: ' + this.editingId);
            return;
        }

        this.editingId = schedule.id;
        console.log('edit status now: ' + this.editingId);
    }

    editRequired(schedule: Schedule): boolean {
        if (schedule.id === this.editingId) {
            return true;
        }

        return false;
    }

    onSetDefault(schedule: Schedule): void {
        if (schedule.id === this.defaultId) {
            this.defaultId = null;
            //curtains.selectedScheduleId, set to null
            console.log('default status now: ' + this.editingId);
            return;
        }

        this.defaultId = schedule.id;
        //curtains.selectedScheduleId, set to null
        console.log('default status now: ' + this.editingId);
    }
}
