import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';
import {ServerResponse} from '../models/ServerResponse.model';
import {DrawTime} from '../models/DrawTime.model';
import {Subject} from 'rxjs';
import {ErrorService} from './error.service';
import {catchError, tap} from 'rxjs/operators';
import {LoadData} from "../models/LoadData.model";

export interface ManualResultSaveResponse{
  success: number;
  data: {
    manualResultId: number,
    drawMaster: object,
    numberCombination: object,
    single: object,
    gameDate: string
  };
  error?: any;
}

@Injectable({
  providedIn: 'root'
})
// @ts-ignore
export class ManualResultService {

  drawTimes: DrawTime[] = [];
  loadData: LoadData[] = [];

  drawTimeSubject = new Subject<DrawTime[]>();
  loadDataSubject = new Subject<LoadData[]>();
  private BASE_API_URL = environment.BASE_API_URL;


  constructor(private http: HttpClient, private errorService: ErrorService) {

    // get all draw time
    this.http.get(this.BASE_API_URL + '/drawTimes').subscribe((response: ServerResponse) => {
      this.drawTimes = response.data;
      this.drawTimeSubject.next([...this.drawTimes]);
    });

    // this.http.get(this.BASE_API_URL + '/dev/getLoadDetails').subscribe((response: ServerResponse) => {
    //   this.loadData = response.data;
    //   this.loadDataSubject.next([...this.loadData]);
    //   // console.log(this.loadData);
    // });
  }

  getLoadData(id){
    this.http.get(this.BASE_API_URL + '/dev/getLoadDetails/' + id).subscribe((response: ServerResponse) => {
      this.loadData = response.data;
      this.loadDataSubject.next([...this.loadData]);
      // console.log(this.loadData);
    });
  }

  getAllDrawTimes(){
    return [...this.drawTimes];
  }

  getLoadDataListener(){
    return this.loadDataSubject.asObservable();
  }

  getAllDrawTimesListener(){
    return this.drawTimeSubject.asObservable();
  }

  saveManualResult(formData){
    return this.http.post<ManualResultSaveResponse>(this.BASE_API_URL + '/manualResult', formData)
      .pipe(catchError(this.errorService.serverError), tap(response => {
      }));
  }
}
