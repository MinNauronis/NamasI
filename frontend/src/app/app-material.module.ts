import {NgModule} from '@angular/core';
import {MatFormFieldModule} from '@angular/material/form-field'
import {MatTooltipModule} from '@angular/material/tooltip';
import {MatInputModule} from "@angular/material/input";

@NgModule({
    imports: [
        MatFormFieldModule,
        MatTooltipModule,
        MatInputModule
    ],
    exports: [
        MatFormFieldModule,
        MatTooltipModule,
        MatInputModule
    ]
})
export class AppMaterialModule {
}
