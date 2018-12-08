import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import {Schedule} from "../objects/schedule";

@Component({
  selector: 'app-schedule-new',
  templateUrl: './schedule-new.component.html',
  styleUrls: ['./schedule-new.component.css']
})
export class ScheduleNewComponent implements OnInit {

  @Output() newSchedule: EventEmitter<Schedule> = new EventEmitter();
  schedule = new Schedule();
  private _isButtonsOn = false;
  private _isCreating = false;

  constructor() { }

  ngOnInit() {
  }

  onCreate() {
    this._isButtonsOn = true;
    this._isCreating = true;
  }

  onConfirm() {
    this.newSchedule.emit(this.schedule);
    console.log(this.schedule);
    this.schedule = new Schedule();
    this.onCancel();
  }

  onCancel() {
    this._isButtonsOn = false;
    this._isCreating = false;
    this.schedule.title = '';
  }

}
