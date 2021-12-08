import { DatePipe } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { CurrentGameResult } from 'src/app/models/CurrentGameResult.model';
import { GameResult } from 'src/app/models/GameResult.model';
import { TodayLastResult } from 'src/app/models/TodayLastResult.model';
import { CommonService } from 'src/app/services/common.service';
import { PlayGameService } from 'src/app/services/play-game.service';
import { ResultService } from 'src/app/services/result.service';
import { FormsModule,ReactiveFormsModule }   from '@angular/forms';
import { CardResultService } from 'src/app/services/card-result.service';
import { CardResult } from 'src/app/models/CardResult.model';


@Component({
  selector: 'app-result',
  templateUrl: './result.component.html',
  styleUrls: ['./result.component.scss']
})
export class ResultComponent implements OnInit {

  todayLastResult: TodayLastResult;
  public currentDateResult: any[];
  public resultByDate: GameResult ;
  currentResult: any[]=[];

  thisYear = new Date().getFullYear();
  thisMonth = new Date().getMonth();
  thisDay = new Date().getDate();
  startDate = new Date(this.thisYear, this.thisMonth, this.thisDay);
  pipe = new DatePipe('en-US');

  cardResult: CardResult[]=[];
  cardResultByDate: CardResult[]=[];

  columnNumber = 8;





  constructor(private playGameService: PlayGameService, private commonService: CommonService, private resultService: ResultService, private cardResultService: CardResultService) {
    this.playGameService.getTodayLastResultListener().subscribe(response => {
      this.todayLastResult = response;
    });
    this.searchResultByDate();

    this.cardResultService.getCardDateResultListener().subscribe(response => {
      this.cardResult = response;
    });
  }

  ngOnInit(): void {
    this.cardResultService.getCardDateResultListener().subscribe(response => {
      this.cardResult = response;
    });

    // this.currentDateResult = this.playGameService.getCurrentDateResult();
    // this.playGameService.getCurrentDateResultListener().subscribe((response: CurrentGameResult) => {
    //   // @ts-ignore
    //   this.currentDateResult = response.result;
    //   console.log("ResultSheetComponent", this.currentDateResult);
    // });
    // console.log("ResultSheetComponent", this.currentDateResult);



    this.resultService.getResultByDateListener().subscribe((response: GameResult) => {
      this.resultByDate = response;
      // console.log(response);
    });
  }

  searchResultByDate(){
    let x = this.pipe.transform(this.startDate,'yyyy-MM-dd');
    // console.log(this.startDate);
    // console.log(x);
    this.resultService.getResultByDate(x).subscribe(response=>{
      // console.log('Component',response);
     // @ts-ignore

      this.currentResult = response.data;
      // console.log(this.currentResult);
    });

  }

  searchCardResultByDate(){
    let x = this.pipe.transform(this.startDate,'yyyy-MM-dd');
    this.cardResultService.getCardResultByDate(x).subscribe(response=>{
     // @ts-ignore

      this.cardResult = response.data;
    });

  }

}

