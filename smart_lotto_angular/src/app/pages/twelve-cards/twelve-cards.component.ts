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
  cardResultVisibility= false;



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

    this.activeDrawTime = this.commonService.getActiveDrawTime();
    this.commonService.getActiveDrawTimeListener().subscribe((response: DrawTime) => {
      this.activeDrawTime = response;
    });

  }

  detailsData(value: string, gameCombination){

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
    // console.log(this.playDetails);

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
        this.inputData = [];
        for (let i = 1; i <= 11 ; i++){
          this.inputData[i] = [];
        }
        this.playDetails = [];
      }
    });

    // console.log(masterData);
    // console.log(this.playDetails);
  }

}
