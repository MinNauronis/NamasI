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


}
