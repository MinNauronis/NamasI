import {Component, OnInit} from '@angular/core';
import {SecurityService} from "../../services/security.service";
import {Router} from '@angular/router';
import {FormBuilder, FormControl, Validators, FormGroupDirective, NgForm} from '@angular/forms';
import {ErrorStateMatcher} from '@angular/material/core';

/** Error when invalid control is dirty, touched, or submitted. */
export class MyErrorStateMatcher implements ErrorStateMatcher {
    isErrorState(control: FormControl | null, form: FormGroupDirective | NgForm | null): boolean {
        const isSubmitted = form && form.submitted;
        return !!(control && control.invalid && (control.dirty || control.touched || isSubmitted));
    }
}

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

    emailFormControl = new FormControl('',
        [
            Validators.required,
            Validators.email
        ]);
    matcher = new MyErrorStateMatcher();
    hidePassword = true;
  passwordForm: FormControl;
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
        this.passwordForm = this._formBuilder.control('',
            Validators.required
        );
    }

    onSubmit() {
        let email = this.emailFormControl.value;
        let password = this.passwordForm.value;
        this.isSubmitted = true;

        this._securityService.loginUser(email, password).subscribe(
            isSuccess => {
                if (isSuccess) {
                    this._router.navigateByUrl('/');
                } else {
                    this.isResponseError = true;
                    setTimeout(() => {
                        this.isResponseError = false;
                        this.isSubmitted = false;
                    }, 2000);
                }
            });
    }
}
