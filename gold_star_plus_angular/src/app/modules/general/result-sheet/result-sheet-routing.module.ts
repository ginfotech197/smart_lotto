import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ResultSheetComponent } from '../../../pages/result-sheet/result-sheet.component';
import {AuthGuardAdminServiceService} from '../../../services/auth-guard-admin-service.service';


const routes: Routes = [
  { path: '', component: ResultSheetComponent }

];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ResultSheetRoutingModule { }
