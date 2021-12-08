import { Component, OnInit } from '@angular/core';
import { CardResult } from 'src/app/models/CardResult.model';
import { CardResultService } from 'src/app/services/card-result.service';
import {DatePipe} from '@angular/common';

@Component({
  selector: 'app-card-result',
  templateUrl: './card-result.component.html',
  styleUrls: ['./card-result.component.scss']
})
export class CardResultComponent implements OnInit {

  cardResult: CardResult[]=[];
  cardResultByDate: CardResult[]=[];



  thisYear = new Date().getFullYear();
  thisMonth = new Date().getMonth();
  thisDay = new Date().getDate();
  startDate = new Date(this.thisYear, this.thisMonth, this.thisDay);
  pipe = new DatePipe('en-US');

  columnNumber = 4;


  constructor(private cardResultService: CardResultService) {
    this.cardResultService.getCardDateResultListener().subscribe(response => {
      this.cardResult = response;
    });
   }

  ngOnInit(): void {
    this.cardResultService.getCardDateResultListener().subscribe(response => {
      this.cardResult = response;
    });

    // this.cardResultService.getCardResultByDateListener().subscribe((response: CardResult[]) => {
    //   this.cardResultByDate = response;
    //   console.log(response);
    // });
  }

  searchCardResultByDate(){
    let x = this.pipe.transform(this.startDate,'yyyy-MM-dd');
    this.cardResultService.getCardResultByDate(x).subscribe(response=>{
     // @ts-ignore

      this.cardResult = response.data;
    });

  }

}
