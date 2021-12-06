import { Component, OnInit } from '@angular/core';
import { CardResult } from 'src/app/models/CardResult.model';
import { CardResultService } from 'src/app/services/card-result.service';

@Component({
  selector: 'app-card-result',
  templateUrl: './card-result.component.html',
  styleUrls: ['./card-result.component.scss']
})
export class CardResultComponent implements OnInit {

  cardResult: CardResult[]=[];

  constructor(private cardResultService: CardResultService) {
    this.cardResultService.getCardDateResultListener().subscribe(response => {
      this.cardResult = response;
    });
   }

  ngOnInit(): void {
    this.cardResultService.getCardDateResultListener().subscribe(response => {
      this.cardResult = response;
      console.log('TS ',this.cardResult);
    });
  }

}
