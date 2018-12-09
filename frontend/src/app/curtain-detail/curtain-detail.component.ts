import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {CurtainService} from "../services/curtain.service";
import {Location} from "@angular/common";
import {Curtain} from "../objects/curtain";
import {ScheduleService} from "../services/schedule.service";
import {Schedule} from "../objects/schedule";
import {FormControl} from '@angular/forms';
import {Subject} from 'rxjs';
import {debounceTime, switchMap} from 'rxjs/operators';

@Component({
    selector: 'app-curtain-detail',
    templateUrl: './curtain-detail.component.html',
    styleUrls: ['./curtain-detail.component.css']
})
export class CurtainDetailComponent implements OnInit {

    curtain: Curtain;
    schedules: Schedule[];
    form = new FormControl();
    //purpose, reduce frequency of update
    updateCurtain = new Subject<any>();

    _hasEditTitle = false;

    tooltipMessageIsClose = 'saulė -> atidaryta,\nmėnulis -> uždaryta';
    tooltipMessageMode = 'atsuktuvas -> rankinis valdymas,\nrodyklės -> automatinis valdymas,\nmygtukas -> išjungta';

    constructor(
        private _route: ActivatedRoute,
        private _router: Router,
        private _curtainService: CurtainService,
        private _scheduleService: ScheduleService,
        private _location: Location
    ) {
    }

    ngOnInit() {
        this.getCurtain();
        this.getSchedules();

        this.form.valueChanges.subscribe(value => this.defaultChangeHandler(value));

        this.updateCurtain.pipe(
            debounceTime(1200),
            switchMap(_ => this._curtainService.updateCurtain(this.curtain))
        ).subscribe(updatedCurtain => console.log(updatedCurtain));
    }

    getCurtain() {
        const id = +this._route.snapshot.paramMap.get('id'); //'+' make id to number
        this._curtainService.getCurtain(id).subscribe(
            curtain => {
                this.curtain = curtain
                this.form.setValue(this.curtain.selectSchedule_id)
            });
    }

    getSchedules() {
        const id = +this._route.snapshot.paramMap.get('id'); //'+' make id to number
        this._scheduleService.getSchedules(id).subscribe(
            schedules => this.schedules = schedules
        );
    }

    setFormValue(value: number | null) {
        //new value should call defaultChangerHandler() via event form.valueChange
        this.form.setValue(value);
    }

    defaultChangeHandler(selectedScheduleId: number | null): void {
        if (this.curtain.selectSchedule_id != selectedScheduleId) {
            this.curtain.selectSchedule_id = selectedScheduleId;
            console.log('curtain received new id: ' + selectedScheduleId);
            this._curtainService.updateCurtain(this.curtain).subscribe(
                curtain => console.log("updated: ", curtain)
            );
        }
    }

    onChangeMode() {
        if (this.curtain.mode === 'off') {
            this.curtain.mode = 'auto';
            this.updateCurtain.next('auto');
            return;
        }

        if (this.curtain.mode === 'auto') {
            this.curtain.mode = 'manual';
            this.updateCurtain.next('manual');
            return;
        }

        //this.curtain.mode === 'manual'
        this.curtain.mode = 'off';
        this.updateCurtain.next('off');
    }

    onChangeOpenClose() {
        if (this.curtain.isClose == false) {
            this.curtain.isClose = true;
            this.updateCurtain.next(true);
            return
        }

        this.curtain.isClose = false;
        this.updateCurtain.next(false);
    }

    onEdit() {
        if (this._hasEditTitle) {
            this._curtainService.updateCurtain(this.curtain).subscribe(curtain => console.log(`name updated ${curtain}`))
        }
        this._hasEditTitle = !this._hasEditTitle;
    }

    onDelete() {
        console.log('detele curtain');
        this._curtainService.deleteCurtain(this.curtain).subscribe(
            curtain => console.log(curtain)
        );
        this._router.navigateByUrl('curtains')
    }


}
