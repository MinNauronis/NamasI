import {NgModule} from '@angular/core';
import {MatFormFieldModule} from '@angular/material/form-field'
import {MatTooltipModule} from '@angular/material/tooltip';
import {MatInputModule} from "@angular/material/input";
import {MatIconModule} from '@angular/material/icon'
import {MatButtonModule} from '@angular/material/button'

@NgModule({
    imports: [
        MatFormFieldModule,
        MatTooltipModule,
        MatInputModule,
        MatIconModule,
        MatButtonModule
    ],
    exports: [
        MatFormFieldModule,
        MatTooltipModule,
        MatInputModule,
        MatIconModule,
        MatButtonModule,
    ]
})
export class AppMaterialModule {
}
