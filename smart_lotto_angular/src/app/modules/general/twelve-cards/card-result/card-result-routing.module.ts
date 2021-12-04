import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { CardResultComponent } from 'src/app/pages/twelve-cards/card-result/card-result.component';


const routes: Routes = [
  { path: '', component: CardResultComponent}
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CardResultRoutingModule { }
