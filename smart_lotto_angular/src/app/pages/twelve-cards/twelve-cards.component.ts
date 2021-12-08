import { Component, OnInit } from '@angular/core';
import {CommonService} from '../../services/common.service';
import {DrawTime} from '../../models/DrawTime.model';
import {User} from '../../models/user.model';
import {AuthService} from '../../services/auth.service';
import {GameType} from '../../models/GameType.model';
import {GameTypeService} from '../../services/game-type.service';
import Swal from 'sweetalert2';
import {PlayGameService} from '../../services/play-game.service';

@Component({
  selector: 'app-twelve-cards',
  templateUrl: './twelve-cards.component.html',
  styleUrls: ['./twelve-cards.component.scss']
})
export class TwelveCardsComponent implements OnInit {
  activeDrawTime: DrawTime;
  user: User;
  playDetails: any[] = [];
  gameTypes: GameType[] = [];
  inputData: any[];
  cardResultVisibility = false;
  totalPurchasedPrice = 0;
  totalPurchasedQuantity = 0;
  alwaysTime: number;
  remainingTime: number;



  constructor(private commonService: CommonService, private authService: AuthService, private gameTypeService: GameTypeService, private playGameService: PlayGameService) {
    this.gameTypes = this.gameTypeService.getGameType();
    this.gameTypeService.getGameTypeListener().subscribe((response: GameType[]) => {
      this.gameTypes = response;
      // console.log(this.gameTypes);
    });

    // console.log(this.gameTypes);
  }

  ngOnInit(): void {

    this.inputData = [];
    for (let i = 1; i <= 11 ; i++){
      this.inputData[i] = [];
    }
    this.cardResultVisibility= false;

    const user = JSON.parse(localStorage.getItem('user'));

    this.authService.userBehaviorSubject.subscribe(user => {
      this.user = user;
    });

    this.commonService.currentTimeBehaviorSubject.asObservable().subscribe(response => {
      this.alwaysTime = response;
    });
    this.commonService.CardRemainingTimeBehaviorSubject.asObservable().subscribe(response => {
      this.remainingTime = response;
      // const x = String(this.remainingTime).split(':');
      // // tslint:disable-next-line:radix
      // this.value = (((parseInt(x[1])*60)+parseInt(x[2]))/(15*60))*100;
    });


    this.activeDrawTime = this.commonService.getActiveDrawTime();
    this.commonService.getActiveDrawTimeListener().subscribe((response: DrawTime) => {
      this.activeDrawTime = response;
    });

  }

  detailsData(value: string, gameCombination){
    let totalPrice = 0;
    let totalQuantity = 0;

    const tempPlayDetail = {
      gameTypeId: this.gameTypes[0].gameTypeId,
      quantity: value,
      cardCombinationId: gameCombination,
      mrp: this.gameTypes[0].mrp,
      payout: this.gameTypes[0].payout,
      commission: this.gameTypes[0].commission
    };
    // console.log(tempPlayDetail);

    // @ts-ignore
    this.playDetails.push(tempPlayDetail);

    this.playDetails.forEach(function(value){
      totalPrice = totalPrice + (value.quantity * value.mrp);
      // tslint:disable-next-line:radix
      totalQuantity = totalQuantity + parseInt(value.quantity) ;
    });
    this.totalPurchasedPrice = totalPrice;
    this.totalPurchasedQuantity = totalQuantity;

    // console.log(this.playDetails);

  }

  clear(){
    this.inputData = [];
    for (let i = 1; i <= 11 ; i++){
      this.inputData[i] = [];
    }
    this.playDetails = [];
    this.totalPurchasedPrice = 0;
    this.totalPurchasedQuantity = 0;
  }

  saveUserInput(){
    // const playMaster = {
    //   drawMasterId: this.activeDrawTime.drawId,
    //   userId: this.user.userId,
    // };

    const masterData = {
      playMaster: {drawMasterId: this.activeDrawTime.drawId, terminalId: this.user.userId},
      playDetails: this.playDetails
    };


    this.playGameService.saveUserPlayInputDetailsCard(masterData).subscribe(response => {
      if (response.success === 1){

        Swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Ticket purchased',
          showConfirmButton: false,
          timer: 1000
        });

        this.authService.setUserBalanceBy(response.remainingBal);
        this.clear();
        // this.inputData = [];
        // for (let i = 1; i <= 11 ; i++){
        //   this.inputData[i] = [];
        // }
        // this.playDetails = [];
      }else{
        Swal.fire({
          position: 'top-end',
          icon: 'error',
          title: 'Validation error',
          showConfirmButton: false,
          timer: 3000
        });
      }
    });

    // console.log(masterData);
    // console.log(this.playDetails);
  }

}
