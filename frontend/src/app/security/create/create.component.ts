import {Component, OnInit} from '@angular/core';
import {
    FormControl,
    Validators,
    FormGroupDirective,
    NgForm,
    FormBuilder,
    FormGroup
} from '@angular/forms';
import {ErrorStateMatcher} from '@angular/material/core';
import {SecurityService} from "../../services/security.service";
import {Router} from '@angular/router';

/** Error when invalid control is dirty, touched, or submitted. */
export class MyErrorStateMatcher implements ErrorStateMatcher {
    isErrorState(control: FormControl | null, form: FormGroupDirective | NgForm | null): boolean {
        const isSubmitted = form && form.submitted;
        return !!(control && control.invalid && (control.dirty || control.touched || isSubmitted));
    }
}

@Component({
    selector: 'app-create',
    templateUrl: './create.component.html',
    styleUrls: ['./create.component.css']
})
export class CreateComponent implements OnInit {

    emailFormControl = new FormControl('',
        [
            Validators.required,
            Validators.email
        ]);
    matcher = new MyErrorStateMatcher();
    hidePassword = true;
    form: FormGroup;
    isSubmitted = false;
    isResponseError = false;

    constructor(
        private _router: Router,
        private _formBuilder: FormBuilder,
        private _securityService: SecurityService) {
    }

    ngOnInit() {
        this.addControls();
    }

    addControls() {
        this.form = this._formBuilder.group({
            'name': ['', Validators.required],
            'password': ['', Validators.required]
        })
    }

    onSubmit() {
        let name = this.form.controls['name'].value;
        let email = this.emailFormControl.value;
        let password = this.form.controls['password'].value;
        //this.isSubmitted = true;

        this._securityService.createUser(name, email, password)
            .subscribe(response => {
                    this._router.navigateByUrl('login');
                },
                response => {
                    console.log(`${response['status']} ${response['error']['errors']['email']}`);
                    this.isResponseError = true;
                    setTimeout(() => {
                        this.isResponseError = false;
                        this.isSubmitted = false;
                    }, 2000);
                }
            );
    }

}
