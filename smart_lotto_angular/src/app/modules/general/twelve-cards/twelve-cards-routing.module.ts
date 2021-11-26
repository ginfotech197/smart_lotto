import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { TwelveCardsComponent } from 'src/app/pages/twelve-cards/twelve-cards.component';

const routes: Routes = [
  { path: '', component: TwelveCardsComponent}
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class TwelveCardsRoutingModule { }
