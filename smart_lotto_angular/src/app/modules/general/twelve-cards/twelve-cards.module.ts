import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TwelveCardsRoutingModule } from './twelve-cards-routing.module';
// import {FormsModule} from '@angular/forms';
import {TwelveCardsComponent} from '../../../pages/twelve-cards/twelve-cards.component';
import {CardResultComponent} from '../../../pages/twelve-cards/card-result/card-result.component';


import { MatBadgeModule } from '@angular/material/badge';
import { MatFormFieldModule } from '@angular/material/form-field';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { MatInputModule } from '@angular/material/input';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatSelectModule } from '@angular/material/select';
import { MatSlideToggleModule } from '@angular/material/slide-toggle';
import { MatButtonModule } from '@angular/material/button';
import { MatButtonToggleModule } from '@angular/material/button-toggle';
import { FlexLayoutModule } from '@angular/flex-layout';
import { NgxPrintModule } from 'ngx-print';
import { NgxWheelModule } from 'ngx-wheel';
import { MatProgressBarModule } from '@angular/material/progress-bar';

import { RouterModule } from '@angular/router';


@NgModule({
  // declarations: [],
  imports: [
    CommonModule,
    TwelveCardsRoutingModule,
    FormsModule,


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
    RouterModule,
    FormsModule,
  ],

  declarations: [
    TwelveCardsComponent,
    CardResultComponent
  ],
  exports: [
    TwelveCardsComponent,
    // CardResultComponent

  ]
})
export class TwelveCardsModule { }
