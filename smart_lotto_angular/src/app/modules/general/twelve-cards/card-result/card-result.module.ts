import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CardResultRoutingModule } from './card-result-routing.module';
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
import { CurrentResultModule } from '../../current-result/current-result.module';
import { RouterModule } from '@angular/router';
import { CardResultComponent } from 'src/app/pages/twelve-cards/card-result/card-result.component';


@NgModule({
  declarations: [
    CardResultComponent,
  ],
  imports: [
    CommonModule,
    CardResultRoutingModule,
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
  exports: [
    CardResultComponent
  ]
})
//@ts-ignore
export class CardResultModule { }
