import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { HomeRoutingModule } from './home-routing.module';
import {HomeComponent} from '../../../pages/home/home.component';
import {FlexLayoutModule} from '@angular/flex-layout';
import {HttpClientModule} from '@angular/common/http';
import {NgbModule} from '@ng-bootstrap/ng-bootstrap';
import {MatSlideToggleModule} from '@angular/material/slide-toggle';
import { ResultSheetComponent } from 'src/app/pages/result-sheet/result-sheet.component';
import {ResultSheetModule} from '../result-sheet/result-sheet.module';
import {TerminalModule} from "../terminal/terminal.module";

// @ts-ignore

@NgModule({
  declarations: [
    HomeComponent,

  ],
  exports: [
    HomeComponent
  ],
  imports: [
    CommonModule,
    HomeRoutingModule,
    FlexLayoutModule,
    HttpClientModule,
    NgbModule,
    MatSlideToggleModule,
    ResultSheetModule,
    TerminalModule
  ]
})
export class HomeModule { }
