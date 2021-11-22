import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { StockistReportComponent } from 'src/app/pages/stockistPanel/stockist-report/stockist-report.component';
import { AuthGuardStockistServiceService } from 'src/app/services/auth-guard-stockist-service.service';

const routes: Routes = [
  { path: '', canActivate : [AuthGuardStockistServiceService], component: StockistReportComponent }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class StockistReportRoutingModule { }
