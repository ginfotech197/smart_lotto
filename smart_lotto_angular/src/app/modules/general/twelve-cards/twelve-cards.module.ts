import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TwelveCardsRoutingModule } from './twelve-cards-routing.module';
import {FormsModule} from '@angular/forms';
import {TwelveCardsComponent} from '../../../pages/twelve-cards/twelve-cards.component';


@NgModule({
  // declarations: [],
  imports: [
    CommonModule,
    TwelveCardsRoutingModule,
    FormsModule
  ],

  declarations: [
    TwelveCardsComponent
  ],
  exports: [
    TwelveCardsComponent
  ]
})
export class TwelveCardsModule { }
