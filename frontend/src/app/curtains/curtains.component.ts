import { Component, OnInit } from '@angular/core';
import {Curtain} from "../objects/curtain";
import {CurtainService} from "../services/curtain.service";

@Component({
  selector: 'app-curtains',
  templateUrl: './curtains.component.html',
  styleUrls: ['./curtains.component.css']
})
export class CurtainsComponent implements OnInit {

  public curtains : Curtain[];

  constructor(private _curtainService: CurtainService) { }

  ngOnInit() {
    this.getCurtains();
  }

  private getCurtains() {
    this._curtainService.getCurtains().
        subscribe(curtains => this.curtains = curtains);
  }


}
