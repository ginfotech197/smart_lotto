import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CpanelRoutingModule } from './cpanel-routing.module';
import {MatCardModule} from '@angular/material/card';
import {FormsModule} from '@angular/forms';
import {MatFormFieldModule} from '@angular/material/form-field';
import {CpanelComponent} from '../../../pages/cpanel/cpanel.component';
import {ManualResultModule} from './manual-result/manual-result.module';
import {NgxPrintModule} from 'ngx-print';
import {ReceiptModule} from '../../../pages/cpanel/receipt/receipt.module';
import { ResultComponent } from 'src/app/pages/cpanel/result/result.component';


@NgModule({
  imports: [
    CommonModule,
    CpanelRoutingModule,
    MatCardModule,
    FormsModule,
    MatFormFieldModule,
    NgxPrintModule,
    ReceiptModule
  ],
  exports: [
    CpanelComponent
  ],
  declarations: [
    CpanelComponent,
    // ResultComponent
  ],
})
export class CpanelModule { }
