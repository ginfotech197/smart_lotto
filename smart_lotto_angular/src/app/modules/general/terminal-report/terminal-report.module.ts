import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TerminalReportRoutingModule } from './terminal-report-routing.module';
import {TerminalReportComponent} from '../../../pages/terminal-report/terminal-report.component';
import {AdminReportsRoutingModule} from "../cpanel/admin-reports/admin-reports-routing.module";
import {MatTabsModule} from "@angular/material/tabs";
import {MaterialModule} from "../../../core/material.module";
import {FlexLayoutModule} from "@angular/flex-layout";
import {MatCardModule} from "@angular/material/card";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {MatSlideToggleModule} from "@angular/material/slide-toggle";
import {MatSortModule} from "@angular/material/sort";
import {NgbModalModule, NgbToastModule} from "@ng-bootstrap/ng-bootstrap";
import {MDBRootModule} from "angular-bootstrap-md";
import {PopoverModule} from "ngx-smart-popover";
import {MatBadgeModule} from "@angular/material/badge";
import {MatDatepickerModule} from "@angular/material/datepicker";
import {MatInputModule} from "@angular/material/input";
import {MatNativeDateModule, MatRippleModule} from "@angular/material/core";
import {MatSelectModule} from '@angular/material/select';


@NgModule({
  imports: [
    CommonModule,
    TerminalReportRoutingModule,
    AdminReportsRoutingModule,
    MatTabsModule,
    MaterialModule,
    MatSelectModule,
    FlexLayoutModule,
    MatCardModule,
    FormsModule,
    ReactiveFormsModule,
    MatSlideToggleModule,
    MatSortModule,
    NgbToastModule,
    NgbModalModule,
    MDBRootModule,
    PopoverModule,
    MatBadgeModule,
    MatDatepickerModule,
    MatInputModule,
    MatNativeDateModule,
    MatRippleModule,
  ],
  declarations: [
    TerminalReportComponent
  ],
  exports: [
    TerminalReportComponent
  ]
})
export class TerminalReportModule { }
