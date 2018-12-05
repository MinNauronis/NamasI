import {NgModule} from '@angular/core';
import {MatFormFieldModule, MatToolbarModule} from "@angular/material";

@NgModule({
    imports: [
        MatFormFieldModule,
        MatToolbarModule
    ],
    exports: [
        MatFormFieldModule,
        MatToolbarModule
    ]
})
export class AppMaterialModule {
}
