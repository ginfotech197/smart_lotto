import { Injectable } from '@angular/core';
import {BehaviorSubject, Subject, timer} from 'rxjs';
import {ProjectData} from '../models/project-data.model';
import {HttpClient} from '@angular/common/http';
import {formatDate} from '@angular/common';
import {ServerResponse} from '../models/ServerResponse.model';
import {environment} from '../../environments/environment';
import {catchError, concatMap, tap} from 'rxjs/operators';
import {DrawTime} from '../models/DrawTime.model';
import {CPanelCustomerSaleReport} from "../models/CPanelCustomerSaleReport.model";
import {TerminalBarcodeReport} from '../models/TerminalBarcodeReport.model';



@Injectable({
  providedIn: 'root'
})
// @ts-ignore
export class CommonService {


  value$ = new BehaviorSubject(20);
  currentTimeBehaviorSubject = new  BehaviorSubject(null);
  remainingTimeBehaviorSubject = new  BehaviorSubject(null);
  CardRemainingTimeBehaviorSubject = new  BehaviorSubject(null);
  currentValue = 0;


  deviceXs = false;
  projectData: ProjectData;
  barcodeReportRecords: TerminalBarcodeReport[] = [];
  public serverTime: {hour: number, minute: number, second: number, 'meridiem': string};
  public currentTimeObj: {hour: number, minute: number, second: number, 'meridiem': string};
  serverTimeSubject = new Subject<{hour: number, minute: number, second: number, 'meridiem': string}>();
  projectDataSubject = new Subject<ProjectData>();
  private pictures: any;
  private BASE_API_URL = environment.BASE_API_URL;

  activeDrawTime: DrawTime;
  CardActiveDrawTime: DrawTime;
  activeDrawTimeSubject = new Subject<DrawTime>();
  cardActiveDrawTimeSubject = new Subject<DrawTime>();

  barcodeReportRecordsSubject = new Subject<TerminalBarcodeReport[]>();
  cardBarcodeReportRecordsSubject = new Subject<TerminalBarcodeReport[]>();

  terminalCancelListListener(){
    return this.barcodeReportRecordsSubject.asObservable();
  }

  terminalCardCancelListListener(){
    return this.cardBarcodeReportRecordsSubject.asObservable();
  }

  constructor(private http: HttpClient) {

    setInterval(() => {
      this.currentValue += 10;
      this.value$.next(this.currentValue);
      // just testing if it is working
    }, 1000);



    this.http.get('assets/ProjectData.json').subscribe((data: ProjectData) => {
      this.projectData = data;
      this.projectDataSubject.next({...this.projectData});
    });

    this.http.get(this.BASE_API_URL + '/serverTime')
      .subscribe((response: {hour: number, minute: number, second: number, 'meridiem': string}) => {
      this.serverTime = response;
      this.currentTimeObj = this.serverTime;
      this.serverTimeSubject.next(this.serverTime);
    });

    setInterval(() => {

      if (this.currentTimeObj.hour === 23 && this.currentTimeObj.minute === 59 && this.currentTimeObj.second > 58)   {
        this.currentTimeObj.hour = 0;
        this.currentTimeObj.minute = 0;
        this.currentTimeObj.second = 1;
      }
      if (this.currentTimeObj.second > 58 && this.currentTimeObj.minute === 59){
        this.currentTimeObj.minute = 0;
        this.currentTimeObj.second = 1;
        this.currentTimeObj.hour++;
        if (this.currentTimeObj.hour === 24){
          this.currentTimeObj.hour = 0;
        }
      }else if (this.currentTimeObj.second > 58){
        this.currentTimeObj.second = 0;
        this.currentTimeObj.minute++;
      }else{
        this.currentTimeObj.second++;
      }
      let currentTime = '';
      let tempHour = this.currentTimeObj.hour < 10 ? '0' + this.currentTimeObj.hour : this.currentTimeObj.hour;
      const tempMinute = this.currentTimeObj.minute < 10 ? '0' + this.currentTimeObj.minute : this.currentTimeObj.minute;
      const tempSecond = this.currentTimeObj.second < 10 ? '0' + this.currentTimeObj.second : this.currentTimeObj.second;
      const tempMeridiem = this.currentTimeObj.meridiem;
      if (this.currentTimeObj.hour > 12){
        tempHour = this.currentTimeObj.hour - 12;
        tempHour = tempHour < 10 ? '0' + tempHour : tempHour;
        currentTime = tempHour + ':' + tempMinute + ':' + tempSecond + '' + tempMeridiem;
      }else{
        currentTime = tempHour + ':' + tempMinute + ':' + tempSecond + '' + tempMeridiem;
      }

      let remainingMin = 0;
      let remainingHour = 0;
      // @ts-ignore
      // const remainingHour = this.activeDrawTime.endTime.split(':')[0] - (this.currentTimeObj.hour);
      // console.log('remainingHour', remainingHour);
      // @ts-ignore
      // if (((this.activeDrawTime.endTime.split(':')[0] - (this.currentTimeObj.hour)) == 1)){
      if ((this.activeDrawTime.endTime.split(':')[0] - (this.currentTimeObj.hour)) === 1){
        // tslint:disable-next-line:no-shadowed-variable
        const remainingHour = 0;
      }else{
        // @ts-ignore
        remainingHour = this.activeDrawTime.endTime.split(':')[0] - (this.currentTimeObj.hour);
      }
      // @ts-ignore
      if (this.activeDrawTime.endTime.split(':')[1] == 0){
        // @ts-ignore
        remainingMin = Math.abs(this.currentTimeObj.minute - 60);
      }else{
       // @ts-ignore
        remainingMin = Math.abs(this.currentTimeObj.minute - this.activeDrawTime.endTime.split(':')[1]);
      }

      // @ts-ignore
      // const remainingSec = Math.abs(60 - (this.currentTimeObj.second-this.activeDrawTime.endTime.split(':')[2]));
      const remainingSec = Math.abs((this.currentTimeObj.second - this.activeDrawTime.endTime.split(':')[2]) - 60);


      let remainingTime ;

      if (remainingHour < 0){
        // tslint:disable-next-line:no-shadowed-variable
        remainingTime = '00:00:00';
      }else{
        // tslint:disable-next-line:no-shadowed-variable
        remainingTime = remainingHour + ':' + remainingMin + ':' + remainingSec;
      }

      // // @ts-ignore
      // const remainingTime = remainingHour + ':' + remainingMin + ':' + remainingSec;

      // console.log('rm_mn: '+ remainingMin , 'rem_sec' + remainingSec);

      if (remainingMin <= 1){
        this.updateTerminalCancellation();
      }

      this.currentTimeBehaviorSubject.next(currentTime);
      this.remainingTimeBehaviorSubject.next(remainingTime);
      // just testing if it is working


      let cardRemainingMin = 0;
      let cardRemainingHour = 0;
      // @ts-ignore
      // const cardRemainingHour = this.CardActiveDrawTime.endTime.split(':')[0] - (this.currentTimeObj.hour);
      // console.log('cardRemainingHour', cardRemainingHour);
      // @ts-ignore
      // if (((this.CardActiveDrawTime.endTime.split(':')[0] - (this.currentTimeObj.hour)) == 1)){
      if ((this.CardActiveDrawTime.endTime.split(':')[0] - (this.currentTimeObj.hour)) === 1){
        // tslint:disable-next-line:no-shadowed-variable
        const cardRemainingHour = 0;
      }else{
        // @ts-ignore
        cardRemainingHour = this.CardActiveDrawTime.endTime.split(':')[0] - (this.currentTimeObj.hour);
      }
      // @ts-ignore
      // tslint:disable-next-line:triple-equals
      if (this.CardActiveDrawTime.endTime.split(':')[1] === 0){
        // @ts-ignore
        cardRemainingMin = Math.abs(this.currentTimeObj.minute - 60);
      }else{
        // @ts-ignore
        cardRemainingMin = Math.abs(this.currentTimeObj.minute - this.CardActiveDrawTime.endTime.split(':')[1]);
      }

      // console.log(cardRemainingMin);
      // @ts-ignore
      // console.log(this.currentTimeObj.minute - this.CardActiveDrawTime.endTime.split(':')[1]);
      // console.log(this.CardActiveDrawTime.endTime.split(':')[1]);
      // @ts-ignore
      // const remainingSec = Math.abs(60 - (this.currentTimeObj.second-this.CardActiveDrawTime.endTime.split(':')[2]));
      const cardRemainingSec = Math.abs((this.currentTimeObj.second - this.CardActiveDrawTime.endTime.split(':')[2]) - 60);

      let cardRemainingTime ;

      console.log(cardRemainingHour);

      // @ts-ignore
      if ((cardRemainingHour <= 0) && (this.currentTimeObj.hour >= this.CardActiveDrawTime.endTime.split(':')[0])){
        // tslint:disable-next-line:no-shadowed-variable
        cardRemainingTime = '00:00:00';
      }else{
        // tslint:disable-next-line:no-shadowed-variable
        cardRemainingTime = cardRemainingHour + ':' + cardRemainingMin + ':' + cardRemainingSec;
      }

      // console.log(cardRemainingMin);

      // @ts-ignore
      // const cardRemainingTime = cardRemainingHour + ':' + cardRemainingMin + ':' + cardRemainingSec;

      // console.log('rm_mn: '+ cardRemainingMin , 'rem_sec' + cardRemainingSec);

      if (cardRemainingMin <= 1){
        this.updateCardTerminalCancellation();
      }

      this.CardRemainingTimeBehaviorSubject.next(cardRemainingTime);


    }, 1000);


    // get active draw
    this.http.get(this.BASE_API_URL + '/dev/drawTimes/active').subscribe((response: ServerResponse) => {
      this.activeDrawTime = response.data;
      this.activeDrawTimeSubject.next({...this.activeDrawTime});
    });

    // get active draw Card
    this.http.get(this.BASE_API_URL + '/dev/drawTimes/activeCard').subscribe((response: ServerResponse) => {
      this.CardActiveDrawTime = response.data;
      this.cardActiveDrawTimeSubject.next({...this.CardActiveDrawTime});
    });

  }

  getServerTime(){
    return {...this.serverTime};
  }

  getServerTimeListener(){
    return this.serverTimeSubject.asObservable();
  }
  getProjectData(){
    return {...this.projectData};
  }
  getVariableSettingsListener(){
    return this.projectDataSubject.asObservable();
  }
  updateVariableSettings(projectData: ProjectData){
    this.projectData = projectData;
    this.projectDataSubject.next({...this.projectData});
  }
  setDeviceXs(dx: boolean){
    this.deviceXs = dx;
  }
  getDeviceXs(): boolean{
    return this.deviceXs;
  }
  getCurrentDate(){
    const now = new Date();
    const currentDate = formatDate(now, 'dd-MM-yyyy', 'en');
    return currentDate;
  }

  updateTerminalCancellation(){
    // @ts-ignore
    return this.http.post( this.BASE_API_URL + '/terminal/updateCancellation').subscribe((response: {success: number, data: TerminalBarcodeReport[]}) => {
      const x = response.data;
      this.barcodeReportRecordsSubject.next([...x]);
    });
  }

  updateCardTerminalCancellation(){
    // @ts-ignore
    return this.http.post( this.BASE_API_URL + '/terminal/updateCardCancellation').subscribe((response: {success: number, data: TerminalBarcodeReport[]}) => {
      const x = response.data;
      this.cardBarcodeReportRecordsSubject.next([...x]);
    });
  }

  loadValue(i) {
    this.currentValue += i;
    this.value$.next(this.currentValue);
    // console.log(this.currentValue);
  }

  getActiveDrawTime(){
    return {...this.activeDrawTime};
  }

  getCardActiveDrawTime(){
    // this.http.get(this.BASE_API_URL + '/dev/drawTimes/activeCard').subscribe((response: ServerResponse) => {
    //   this.CardActiveDrawTime = response.data;
    //   this.cardActiveDrawTimeSubject.next({...this.CardActiveDrawTime});
    // });
    return {...this.CardActiveDrawTime};
  }

  getActiveDrawTimeListener(){
    return this.activeDrawTimeSubject.asObservable();
  }

  getCardActiveDrawTimeListener(){
    return this.cardActiveDrawTimeSubject.asObservable();
  }

  getActiveServerDrawTime(){
    // get active draw
    this.http.get(this.BASE_API_URL + '/dev/drawTimes/active').subscribe((response: ServerResponse) => {
      this.activeDrawTime = response.data;
      this.activeDrawTimeSubject.next({...this.activeDrawTime});
    });

    // get active draw card
    this.http.get(this.BASE_API_URL + '/dev/drawTimes/activeCard').subscribe((response: ServerResponse) => {
      this.CardActiveDrawTime = response.data;
      this.cardActiveDrawTimeSubject.next({...this.CardActiveDrawTime});
    });
  }

}
