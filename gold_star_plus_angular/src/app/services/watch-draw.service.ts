import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';
import {Subject} from 'rxjs';
import {GameResultService} from './game-result.service';
import {PlayGameService} from './play-game.service';
import {NextDrawId} from '../models/NextDrawId.model';
import {User} from '../models/user.model';
import {CommonService} from './common.service';
import {ServerResponse} from "../models/ServerResponse.model";
import {LastResult} from "../models/LastResult.model";

@Injectable({
  providedIn: 'root'
})
// @ts-ignore
export class WatchDrawService {

  private BASE_API_URL = environment.BASE_API_URL;
  private nextDrawId: NextDrawId = {};
  public showCurrentResult = false;
  lastResult: LastResult;
  nextDrawSubject = new Subject<NextDrawId>();
  lastResultSubject = new Subject<LastResult[]>();


  lastResultListener(){
    return this.lastResultSubject.asObservable();
  }

  constructor(private http: HttpClient, private gameResultService: GameResultService, private playGameService: PlayGameService
              // tslint:disable-next-line:align
              , private commonService: CommonService) {

    this.http.get(this.BASE_API_URL + '/dev/results/lastResult').subscribe((response: ServerResponse) => {
      this.lastResult = response.data;
      // @ts-ignore
      this.lastResultSubject.next([...this.lastResult]);
    });

      const userData: User = JSON.parse(localStorage.getItem('user'));
      setInterval(() => {
      this.http.get(this.BASE_API_URL + '/dev/nextDrawId').subscribe((response: NextDrawId) => {

        // console.log(response);

        if (Object.entries(this.nextDrawId).length === 0){
          this.nextDrawId = response;
          this.nextDrawSubject.next({...this.nextDrawId});
          if (userData == null){
            this.gameResultService.getUpdatedResult();
          }else{
            this.gameResultService.getUpdatedResult();
            this.playGameService.getTodayLastResult();
            this.playGameService.getTodayResult();
          }

        }else if (this.nextDrawId.data.id !== response.data.id) {
          this.showCurrentResult = true;
          this.getLastResult();
          this.nextDrawId = response;
          this.nextDrawSubject.next({...this.nextDrawId});
          if (userData == null){
            this.gameResultService.getUpdatedResult();
          }else{
            this.gameResultService.getUpdatedResult();
            this.playGameService.getTodayLastResult();
            this.playGameService.getTodayResult();
            this.commonService.getActiveServerDrawTime();
            this.commonService.updateTerminalCancellation();
          }
        }

      });
    }, 3000);
  }

  getLastResult(){
    this.http.get(this.BASE_API_URL + '/dev/results/lastResult').subscribe((response: ServerResponse) => {
      this.lastResult = response.data;
      // console.log(this.lastResult);
      // @ts-ignore
      this.lastResultSubject.next([...this.lastResult]);
    });
  }

  getResult(){
    return {...this.lastResult};
  }

  getNextDraw(){
    return {...this.nextDrawId};
  }
  getNextDrawListener(){
    return this.nextDrawSubject.asObservable();
  }
}
