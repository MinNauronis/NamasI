import {Component, Input, OnInit, Output, EventEmitter} from '@angular/core';
import {ScheduleService} from "../services/schedule.service";
import {Schedule} from "../objects/schedule";

@Component({
    selector: 'app-schedules',
    templateUrl: './schedules.component.html',
    styleUrls: ['./schedules.component.css']
})

export class SchedulesComponent implements OnInit {
    /**
     * @var receivedDefaultId -> curtain.selectedScheduleId
     * @var sendDefaultId -> curtain.selectedScheduleId
     */
    @Input() curtainId: number;

    @Input()
    set defaultId(receivedDefaultId: any) {
        this._defaultId = receivedDefaultId;
    }

    @Output() sendDefaultId: EventEmitter<number> = new EventEmitter();

    private _defaultId: number;
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
        this._scheduleService.getSchedules(this.curtainId)
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
        return schedule === this.selectedSchedule;
    }

    onDelete(schedule: Schedule): void {
        console.log('want to delete');
        this.schedules = this.schedules.filter(h => h !== schedule);
        this._scheduleService.deleteSchedule(this.curtainId, schedule).subscribe(
            message => console.log(message)
        );
    }

    editRequired(schedule: Schedule): boolean {
        return schedule.id === this.editingId;
    }

    isScheduleDefault(schedule: Schedule): boolean {
        return schedule.id != null && schedule.id === this._defaultId;
    }

    /**
     * Set editingId to schedule's witch has to be editable
     * @param schedule
     */
    onEdit(schedule: Schedule): void {
        //save by schedule
        if (schedule.id === this.editingId) {
            this.editingId = null;
            this.updateSchedule(schedule);
            console.log('edit status now: ' + this.editingId);
            return;
        }

        //save by editingId
        if (this.editingId != null) {
            this.updateSchedule(this.schedules[this.editingId]);
        }

        this.editingId = schedule.id;
        console.log('edit status now: ' + this.editingId);
    }

    isEditing(schedule: Schedule) :boolean {
        return this.editingId === schedule.id;
    }

    onSetDefault(schedule: Schedule): void {
        this.setDefaultId(schedule.id);
        this.sendDefaultId.emit(this._defaultId);
        //curtains.selectedScheduleId, set to null
        console.log('default status now: ' + this._defaultId);
    }

    setDefaultId(value: number) {
        if (value === this._defaultId) {
            this._defaultId = null;
        } else {
            this._defaultId = value;
        }
    }

    private updateSchedule(schedule: Schedule) {
        this._scheduleService.updateSchedule(this.curtainId, schedule).subscribe(
            updated => console.log(updated)
        );
    }

    public createSchedule(schedule: Schedule) {
        this._scheduleService.addSchedule(this.curtainId, schedule).subscribe(
            created => this.schedules.push(created)
        );
    }
}
