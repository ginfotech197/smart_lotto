import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TwelveCardsRoutingModule } from './twelve-cards-routing.module';
import {FormsModule} from '@angular/forms';
import {TwelveCardsComponent} from '../../../pages/twelve-cards/twelve-cards.component';
import {CardResultComponent} from '../../../pages/twelve-cards/card-result/card-result.component';


@NgModule({
  // declarations: [],
  imports: [
    CommonModule,
    TwelveCardsRoutingModule,
    FormsModule
  ],

  declarations: [
    TwelveCardsComponent,
    CardResultComponent
  ],
  exports: [
    TwelveCardsComponent
  ]
})
export class TwelveCardsModule { }
