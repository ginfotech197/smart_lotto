import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ResultSheetRoutingModule } from './result-sheet-routing.module';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import {ResultSheetComponent} from "../../../pages/result-sheet/result-sheet.component";
import {MatNativeDateModule} from "@angular/material/core";
import {MatButtonModule} from "@angular/material/button";
import {MatFormFieldModule} from "@angular/material/form-field";
import {MatDatepickerModule} from "@angular/material/datepicker";
import { ResultComponent } from '../../../pages/cpanel/result/result.component';
import {TerminalRoutingModule} from "../terminal/terminal-routing.module";
import {MatBadgeModule} from "@angular/material/badge";
import {MatInputModule} from "@angular/material/input";
import {MatSelectModule} from "@angular/material/select";
import {MatSlideToggleModule} from "@angular/material/slide-toggle";
import {MatButtonToggleModule} from "@angular/material/button-toggle";
import {FlexLayoutModule} from "@angular/flex-layout";
import {NgxPrintModule} from "ngx-print";
import {NgxWheelModule} from "ngx-wheel";
import {MatProgressBarModule} from "@angular/material/progress-bar";
import {CurrentResultModule} from "../current-result/current-result.module";
import {RouterModule} from "@angular/router";





@NgModule({
  // declarations: [],
  imports: [
    CommonModule,
    ResultSheetRoutingModule,
    FormsModule,
    ReactiveFormsModule,
    MatDatepickerModule,
    MatButtonModule,
    MatFormFieldModule,
    MatNativeDateModule,

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


  ],
  declarations: [
    ResultSheetComponent,
    //ResultComponent
  ],
  exports: [
    ResultSheetComponent,
    //ResultComponent
  ]

})
export class ResultSheetModule { }
