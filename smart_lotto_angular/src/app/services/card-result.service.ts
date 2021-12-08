import { Injectable } from '@angular/core';
import {environment} from '../../environments/environment';
// import {HttpClient} from '@angular/common/http';
import {CurrentGameResult} from '../models/CurrentGameResult.model';
import {Subject, throwError} from "rxjs";
import {ErrorService} from './error.service';
import {AuthService} from './auth.service';
import {ServerResponse} from '../models/ServerResponse.model';
import { GameResult } from '../models/GameResult.model';
import { catchError, tap } from 'rxjs/operators';
import {HttpClient, HttpErrorResponse} from "@angular/common/http";
import { CardResult } from '../models/CardResult.model';





@Injectable({
  providedIn: 'root'
})
// @ts-ignore
export class CardResultService {

  private BASE_API_URL = environment.BASE_API_URL;
  currentDateResult: CurrentGameResult;
  cardResult: CardResult[]=[];
  cardResultSubject = new Subject<CardResult[]>();
  cardResultByDateSubject = new Subject<CardResult[]>();
  resultByDateSubject = new Subject<GameResult>();
  resultByDate: GameResult;



  // cardResult: C

  currentDateResultSubject = new Subject<CurrentGameResult>();

  constructor(private http: HttpClient, private errorService: ErrorService, private authService: AuthService) {
    this.http.get(this.BASE_API_URL + '/dev/results/currentDate').subscribe((response: ServerResponse) => {
        this.currentDateResult = response.data;
        this.currentDateResultSubject.next({...this.currentDateResult});
      });
    this.http.get(this.BASE_API_URL + '/dev/cardResult').subscribe((response: ServerResponse) =>{
      this.cardResult = response.data.result;
      this.cardResultSubject.next([...this.cardResult]);
    });

    // this.http.get(this.BASE_API_URL + 'getResultByDate').subscribe((response: ServerResponse) => {
    //   this.resultByDate = response.data;
    //   this.resultByDateSubject.next({...this.resultByDate});
    // });


  }

  getCardResultByDate(cardResultDate: any){
    return this.http.post(this.BASE_API_URL + '/dev/cardReultByDate', {game_date: cardResultDate}).pipe(catchError(this.handleError),
    tap(((response: {success: number, data: CardResult[]}) => {
    })));
  }





  getCurrentDateResult(){
    return {...this.currentDateResult};
  }
  getCurrentDateResultListener(){
    return this.currentDateResultSubject.asObservable();
  }

  // getResultByDate(){
  //   return {...this.resultByDate};
  // }

  getCardResultByDateListener(){
    return this.cardResultByDateSubject.asObservable();
  }

  private handleError(errorResponse: HttpErrorResponse){
    if (errorResponse.error.message.includes('1062')){
      return throwError('Record already exists');
    }else {
      return throwError(errorResponse.error.message);
    }
  }


  getCardDateResult(){
    return {...this.cardResult};
  }
  getCardDateResultListener(){
    return this.cardResultSubject.asObservable();
  }

}
