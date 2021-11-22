import {Component, OnInit, Renderer2, ViewChild} from '@angular/core';
import {GameResultService} from '../../services/game-result.service';
import {GameResult} from '../../models/GameResult.model';
import {Meta} from '@angular/platform-browser';
import {formatDate} from '@angular/common';
import {CommonService} from '../../services/common.service';
import {environment} from '../../../environments/environment';
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';
import {WatchDrawService} from '../../services/watch-draw.service';

import {TwoDigitNumberSet} from '../../models/TwoDigitNumberSet.model';
import { PlayGameService } from 'src/app/services/play-game.service';

import {TodayLastResult} from '../../models/TodayLastResult.model';
import {LastResult} from '../../models/LastResult.model';
import Swal from 'sweetalert2';
import { CurrentGameResult } from 'src/app/models/CurrentGameResult.model';
import { DrawTime } from 'src/app/models/DrawTime.model';
import { ProjectData } from 'src/app/models/project-data.model';
import { SingleNumber } from 'src/app/models/SingleNumber.model';
import { GameType } from 'src/app/models/GameType.model';
import { NextDrawId } from 'src/app/models/NextDrawId.model';
import { Router } from '@angular/router';
import { GameTypeService } from 'src/app/services/game-type.service';
import { NgxPrinterService } from 'ngx-printer';
import { AuthService } from 'src/app/services/auth.service';
import { GameInputSaveResponse } from 'src/app/models/GameInputSaveResponse.model';
import { UserGameInput } from 'src/app/models/userGameInput.model';
import { ThemePalette } from '@angular/material/core';
import { NgxWheelComponent, TextAlignment, TextOrientation } from 'ngx-wheel';
import { User } from 'src/app/models/user.model';


@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  @ViewChild(NgxWheelComponent, { static: false }) wheel;
  seed = [...Array(10).keys()];
  idToLandOn: any;
  items: any[];
  textOrientation: TextOrientation = TextOrientation.HORIZONTAL;
  textAlignment: TextAlignment = TextAlignment.OUTER;
  StartDateFilter = 1;

  inputData: any[][];


  // for progressbar
  value = 0;
  // color: ThemePalette = 'warn';
  color: ThemePalette = 'accent';

  projectData: ProjectData;
  remainingTime: number;
  alwaysTime: number;
  showDeveloperDiv = true;
  user: User;
  singleNumbers: SingleNumber[] = [];
  numberCombinationMatrix: SingleNumber[] = [];
  twoDigitNumberSet: TwoDigitNumberSet[] = [];
  activeDrawTime: DrawTime;
  chips: number[] = [];
  gameTypes: GameType[] = [];
  userGameInput: any[] = [];
  public totalTicketPurchased: number;
  currentDateResult: CurrentGameResult;
  todayLastResult: TodayLastResult;
  nextDrawId: NextDrawId;

  playDetails: UserGameInput[] = [];

  customInput: number;

  columnNumber = 5;
  columnNumber2 = 8;
  columnNumber3 = 1;



  public activeTripleContainerValue = 0;
  public selectedChip = 10;
  public previousChip = 10;
  public selectedChipValue = 10;
  public counter = 0;
  public colorName = ['#FE0C4D', '#85FE0C', '#1DA4FE', '#FE7701', '#BB01FE'];
  copyNumberMatrix: SingleNumber[];
  copySingleNumber: SingleNumber[];
  isProduction = environment.production;
  showDevArea = false;
  currentDate: string;
  deviceXs: boolean;
  lastResult: LastResult[];

  timeoutSec = 10;

  public showCurrentResult = false;
  public showResultSheet = false;
  public lastPurchasedTicketDetails: GameInputSaveResponse;
  public lastPurchasedTicketSingle: {singleNumber: number, quantity: number}[];
  public lastPurchasedTicketTriple: {visibleTripleNumber: number, quantity: number, singleNumber: number}[];

  constructor(private playGameService: PlayGameService, private commonService: CommonService, private authService: AuthService,
              private ngxPrinterService: NgxPrinterService, private renderer: Renderer2, private watchDrawService: WatchDrawService,
              private gameTypeService: GameTypeService, private route: Router
  ) {

    this.inputData = [];
    for (let i = 0; i <= 6 ; i++){
      this.inputData[i] = [];
      for (let j = 0 ; j <= 10 ; j++){
        this.inputData[i][j] = [];
      }
    }

    // @ts-ignore
    this.lastResult = this.watchDrawService.getResult();

    this.watchDrawService.lastResultSubject.subscribe((response) => {
      this.lastResult = response;
    });
    // this.renderer.setStyle(document.body, 'background-image', ' url("assets/images/curtain.jpg")');
    // this.renderer.setStyle(document.body.firstChild., 'background-image', ' url("assets/images/curtain.jpg")');
    const layer = document.querySelector('.layer');
    if (screen.width < 800){
      this.renderer.setStyle(layer, 'height', '140%');
    }
    this.renderer.setStyle(layer, 'width', '36cm');
    this.renderer.setStyle(layer, 'overflow', 'hidden');
    this.currentDate = this.commonService.getCurrentDate();
    this.deviceXs = this.commonService.deviceXs;

    this.playGameService.getTodayLastResultListener().subscribe(response => {
      this.todayLastResult = response;
    });

    this.watchDrawService.getNextDrawListener().subscribe((response: NextDrawId) => {
      this.nextDrawId = response;
      this.showCurrentResult = this.watchDrawService.showCurrentResult;
      if (this.showCurrentResult){
        this.showResultSheet = false;
      }
      setTimeout(() => {
        this.watchDrawService.showCurrentResult = false;
        this.showCurrentResult = false;
      }, (this.timeoutSec * 1000));
      // if (this.todayLastResult !== undefined){
      //   console.log(this.todayLastResult.data);
      //   this.spin(this.todayLastResult.data.single_number).then(r => {});
      // }
    });
    // this.spin(5).then(r => {console});
    this.gameTypes = this.gameTypeService.getGameType();
    this.gameTypeService.getGameTypeListener().subscribe((response: GameType[]) => {
      this.gameTypes = response;
      this.gameTypes = this.gameTypes.filter(x => x.gameTypeId);
    });
    this.gameTypes = this.gameTypes.filter(x => x.gameTypeId);
  }

  ngOnInit(): void {


    // let audio = new Audio();
    // audio.src = "sound/Wheel.wav";
    // audio.load();
    // audio.play();

    this.authService.userBehaviorSubject.subscribe(user => {
      this.user = user;
    });

    this.idToLandOn = this.seed[Math.floor(Math.random() * this.seed.length)];
    const colors = ['#FFA500', '#8B008B', '#FF1493', '#20B2AA', '#8B0000', '#00FF00', '#e0e000', '#0000FF', '#6A5ACD', '#cd5c5c'];
    this.items = this.seed.map((value) => ({
      fillStyle: colors[value % 10],
      text: `${value}`,
      id: value,
      textFillStyle: 'white',
      textFontSize: '40'
    }));



    this.renderer.setStyle(document.body, 'background-color', 'white');
    this.user = this.authService.userBehaviorSubject.value;
    this.numberCombinationMatrix = this.playGameService.getNumberCombinationMatrix();
    // this.numberCombinationMatrix  = JSON.parse(JSON.stringify(this.copyNumberMatrix));
    this.playGameService.getNumberCombinationMatrixListener().subscribe((response: SingleNumber[]) => {
      this.numberCombinationMatrix = response;
      this.copyNumberMatrix  = JSON.parse(JSON.stringify(this.numberCombinationMatrix));
    });

    // this.singleNumbers = this.playGameService.getSingleNumbers();
    this.singleNumbers = this.playGameService.getSingleNumbersFromDatabase();
    this.playGameService.getSingleNumberListener().subscribe((response: SingleNumber[]) => {
      this.singleNumbers = response;
      this.copySingleNumber = JSON.parse(JSON.stringify(this.singleNumbers));
    });

    this.commonService.currentTimeBehaviorSubject.asObservable().subscribe(response => {
      this.alwaysTime = response;
    });

    // variableSettings enabling
    this.projectData = this.commonService.getProjectData();
    this.chips = this.projectData.chips;
    this.commonService.getVariableSettingsListener().subscribe((response: ProjectData) => {
      this.projectData = response;
      this.chips = this.projectData.chips;
    });

    let tempSecTime = null;
    let tempMinTime = null;
    this.activeDrawTime = this.commonService.getActiveDrawTime();
    this.commonService.getActiveDrawTimeListener().subscribe((response: DrawTime) => {
        this.activeDrawTime = response;
        tempSecTime = this.activeDrawTime.startTime.split(':')[2];
        tempMinTime = this.activeDrawTime.startTime.split(':')[1];
        if ((((new Date().getSeconds()) - tempSecTime) < this.timeoutSec) && ((new Date().getMinutes()) - tempMinTime) <= 0){
          this.showCurrentResult = true;
        }
    });

    if (this.activeDrawTime.startTime !== undefined){
      tempSecTime = this.activeDrawTime.startTime.split(':')[2];
      tempMinTime = this.activeDrawTime.startTime.split(':')[1];
    }

    if ((((new Date().getSeconds()) - tempSecTime) < this.timeoutSec) && ((new Date().getMinutes()) - tempMinTime) <= 0){
      this.showCurrentResult = true;
    }

    this.currentDateResult = this.playGameService.getCurrentDateResult();
    this.playGameService.getCurrentDateResultListener().subscribe((response: CurrentGameResult) => {
      this.currentDateResult = response;
    });

    this.twoDigitNumberSet =  this.playGameService.getTwoDigitNumberSetNumbers();
    this.playGameService.getTwoDigitNumberSetListener().subscribe((response: TwoDigitNumberSet[]) => {
      this.twoDigitNumberSet = response;
      console.log(this.twoDigitNumberSet);
    });

    this.nextDrawId = this.watchDrawService.getNextDraw();

    this.commonService.remainingTimeBehaviorSubject.asObservable().subscribe(response => {
      this.remainingTime = response;
      // console.log(this.remainingTime);
      const x = String(this.remainingTime).split(':');
      // tslint:disable-next-line:radix
      const minToSec = parseInt(x[1]) * 60;
      // tslint:disable-next-line:radix
      const hourToSec = parseInt(x[0]) * 3600;
      // tslint:disable-next-line:radix
      const sec = parseInt(x[2]);
      const timeDiffMinToSec = this.activeDrawTime.time_diff * 60;
      // tslint:disable-next-line:radix
      this.value = ((hourToSec + minToSec + sec) / timeDiffMinToSec) * 100;
      // console.log(this.value);
    });

  }// end of ngOnIInit

  initializeValue(value){
    if (this.previousChip === 0){
      this.previousChip = value;
    }
    if (this.previousChip !== this.selectedChip){
      this.counter = 0;
    }
    if (this.selectedChip === 10 ){
      this.counter  = this.counter + 1;
      this.selectedChipValue = this.selectedChip * this.counter;
    }
    if (this.selectedChip === 20 ){
      this.counter  = this.counter + 1;
      this.selectedChipValue = this.selectedChip * this.counter;
    }
    if (this.selectedChip === 50 ){
      this.counter  = this.counter + 1;
      this.selectedChipValue = this.selectedChip * this.counter;
    }
    if (this.selectedChip === 100 ){
      this.counter  = this.counter + 1;
      this.selectedChipValue = this.selectedChip * this.counter;
    }

    // console.log(value.quantity);
    if (value.quantity){
      value.quantity = value.quantity + (this.selectedChip / this.gameTypes[0].mrp);
    }else{
      value.quantity = (this.selectedChip / this.gameTypes[0].mrp);
    }



    this.setValue(value.quantity, value );

  }

  reset() {
    this.wheel.reset();
  }
  before() {
    // console.log('Your wheel is about to spin');
  }

  async spin(prize) {
    this.idToLandOn = prize;
    await new Promise(resolve => setTimeout(resolve, 0));
    this.wheel.spin();
  }


  isActiveTripleContainter(idxSingle: number) {
    // tslint:disable-next-line:triple-equals
    return this.activeTripleContainerValue == idxSingle;
  }

  setActiveTripleContainerValue(i: number) {
    this.activeTripleContainerValue = i;
  }

  setValue(points, value){
    const gameId = 1;
    // tslint:disable-next-line:radix
    this.customInput = parseInt(points) ;
    // this.setGameInputSet(value,1,1);

    let index = -1;

    if (gameId == 1){
      index = this.userGameInput.findIndex(x => x.singleNumberId === value.singleNumberId);
      // tslint:disable-next-line:triple-equals
    }else if (gameId == 2){
      index = this.userGameInput.findIndex(x => x.numberCombinationId === value.numberCombinationId);
    }

    // index = this.userGameInput.findIndex(x => x.singleNumberId === value.singleNumberId);
    if (index > -1){
      this.userGameInput[index].quantity = this.customInput;
      value.quantity = this.userGameInput[index].quantity;
      this.customInput = null;
    }else{
      const tempPlayDetails = {
        gameTypeId: 1,
        numberCombinationId: value.numberCombinationId,
        singleNumberId: value.singleNumberId,
        quantity: this.customInput,
        mrp: this.gameTypes[0].mrp
      };
      this.userGameInput.push(tempPlayDetails);
      value.quantity = this.customInput;
      this.customInput = null;
    }

    let x = 0;
    this.userGameInput.forEach(function(value) {
      const tempQuantity = (value.quantity) ? (value.quantity) : 0;
      x = x + tempQuantity;
    });
    this.totalTicketPurchased = x;

    if (this.totalTicketPurchased){
      this.totalTicketPurchased = this.totalTicketPurchased * this.gameTypes[0].mrp;
    }else{
      this.totalTicketPurchased = null;
    }

  }

  removeDuplicates(data){
    data.filter((value, index) => data.indexOf(value) === index);
  }

  clear(){
    this.inputData = [];
    for (let i = 0; i <= 6 ; i++){
      this.inputData[i] = [];
      for (let j = 0 ; j <= 10 ; j++){
        this.inputData[i][j] = [];
      }
    }
    this.playDetails = [];
    this.playDetails = [];
    this.totalTicketPurchased = 0;
  }


  viewResult(){
    this.showResultSheet = true ;
  }


}

