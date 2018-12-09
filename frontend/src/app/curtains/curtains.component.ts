import {Component, OnInit} from '@angular/core';
import {Curtain} from "../objects/curtain";
import {CurtainService} from "../services/curtain.service";

@Component({
    selector: 'app-curtains',
    templateUrl: './curtains.component.html',
    styleUrls: ['./curtains.component.css']
})
export class CurtainsComponent implements OnInit {

    public curtains: Curtain[];
    newCurtain = new Curtain();
    createButtonsHidden = true;

    constructor(private _curtainService: CurtainService) {
    }

    ngOnInit() {
        console.log(localStorage.getItem('accessToken'));
        this.getCurtains();
    }

    private getCurtains() {
        this._curtainService.getCurtains().subscribe(curtains => this.curtains = curtains);
    }

    onNewConfirm() {
        if (this.newCurtain.title != '') {
            this._curtainService.addCurtain(this.newCurtain).subscribe(curtain => this.curtains.push(curtain));
            this.onNewCancel();
        }
    }

    onNewCreate() {
        this.createButtonsHidden = false;
    }

    onNewCancel() {
        this.createButtonsHidden = true;
        this.newCurtain.title = '';
    }
}
