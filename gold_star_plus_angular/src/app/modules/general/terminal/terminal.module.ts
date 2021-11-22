import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TerminalRoutingModule } from './terminal-routing.module';
import {TerminalComponent} from '../../../pages/terminal/terminal.component';
// import {CurrentResultComponent} from '../../../pages/current-result/current-result.component';
import {MatBadgeModule} from '@angular/material/badge';
import {MatFormFieldModule} from '@angular/material/form-field';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {MatInputModule} from '@angular/material/input';
import {MatDatepickerModule} from '@angular/material/datepicker';
import {MatSelectModule} from '@angular/material/select';
import {MatButtonModule} from '@angular/material/button';
import {MatSlideToggleModule} from '@angular/material/slide-toggle';
import {MatButtonToggleModule} from '@angular/material/button-toggle';
import {FlexLayoutModule} from '@angular/flex-layout';
import {NgxPrintModule} from 'ngx-print';
import {NgxWheelModule} from 'ngx-wheel';
import {MatProgressBar, MatProgressBarModule} from '@angular/material/progress-bar';
import {CurrentResultModule} from '../current-result/current-result.module';
import {CurrentResultComponent} from '../../../pages/current-result/current-result.component';
import { ResultSheetComponent } from 'src/app/pages/result-sheet/result-sheet.component';
import {RouterModule} from "@angular/router";

import {MatNativeDateModule} from "@angular/material/core";
import { ResultComponent } from 'src/app/pages/cpanel/result/result.component';
import {ResultSheetModule} from '../result-sheet/result-sheet.module';



@NgModule({
  imports: [
    CommonModule,
    TerminalRoutingModule,
    MatBadgeModule,
    MatFormFieldModule,
    ReactiveFormsModule,
    MatInputModule,
    MatDatepickerModule,
    MatSelectModule,
    MatSlideToggleModule,
    MatBadgeModule,
    MatButtonModule,
    MatButtonToggleModule,
    FlexLayoutModule,
    NgxPrintModule,
    NgxWheelModule,
    MatProgressBarModule,
    CurrentResultModule,
    RouterModule,
    FormsModule,

    MatDatepickerModule,
    MatButtonModule,
    MatFormFieldModule,
    MatNativeDateModule,
    ResultSheetModule
  ],
  declarations: [
    TerminalComponent,
    CurrentResultComponent,
    // ResultSheetComponent,
  ],
    exports: [
        TerminalComponent,
        CurrentResultComponent
    ]
})
export class TerminalModule { }

