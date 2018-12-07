import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from "@angular/router";
import {CurtainService} from "../services/curtain.service";
import {Location} from "@angular/common";
import {Curtain} from "../objects/curtain";

@Component({
    selector: 'app-curtain-detail',
    templateUrl: './curtain-detail.component.html',
    styleUrls: ['./curtain-detail.component.css']
})
export class CurtainDetailComponent implements OnInit {

    public curtain : Curtain;

    constructor(
        private _route: ActivatedRoute,
        private _curtainService: CurtainService,
        private _location: Location
    ) {
    }

    ngOnInit() {
        this.getCurtain();
    }

    getCurtain() {
        const id = +this._route.snapshot.paramMap.get('id'); //'+' make id to number
        this._curtainService.getCurtain(id).subscribe(curtain => this.curtain = curtain);
    }

    defaultChangeHandler(selectedScheduleId: number ){
       this.curtain.selectSchedule_id = selectedScheduleId;
       console.log(selectedScheduleId);
    }

    onChangeMode() {
        if (this.curtain.mode === 'off') {
            this.curtain.mode = 'auto';
            return;
        }

        if (this.curtain.mode === 'auto') {
            this.curtain.mode = 'manual';
            return;
        }

        if (this.curtain.mode === 'manual') {
            this.curtain.mode = 'off';
            return;
        }
    }

    onChangeOpenClose() {
        if(this.curtain.isClose == false) {
            this.curtain.isClose = true;
            return
        }

        this.curtain.isClose = false;
    }

}
