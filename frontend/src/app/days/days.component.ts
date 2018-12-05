import { Component, OnInit, Input } from '@angular/core';
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

  @Input() scheduleId : number;

  public days : Day[];

  constructor(
      private _route: ActivatedRoute,
      private _dayService: DayService,
      private _location: Location
  ) { }

  ngOnInit() {
    this.getDays();
  }

  getDays() {
    this._dayService.getDays(this.scheduleId).subscribe(
        fetchedDays => this.days = fetchedDays
    )
  }
}
