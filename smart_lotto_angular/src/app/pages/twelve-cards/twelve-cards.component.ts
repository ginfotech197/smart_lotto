import { Component, OnInit } from '@angular/core';
import {CommonService} from '../../services/common.service';
import {DrawTime} from '../../models/DrawTime.model';
import {User} from '../../models/user.model';
import {AuthService} from '../../services/auth.service';

@Component({
  selector: 'app-twelve-cards',
  templateUrl: './twelve-cards.component.html',
  styleUrls: ['./twelve-cards.component.scss']
})
export class TwelveCardsComponent implements OnInit {
  activeDrawTime: DrawTime;
  user: User;



  constructor(private commonService: CommonService, private authService: AuthService) { }

  ngOnInit(): void {
    const user = JSON.parse(localStorage.getItem('user'));

    this.authService.userBehaviorSubject.subscribe(user => {
      this.user = user;
    });

    this.activeDrawTime = this.commonService.getActiveDrawTime();
    this.commonService.getActiveDrawTimeListener().subscribe((response: DrawTime) => {
      this.activeDrawTime = response;
    });

  }

  detailsData(value: string){
    console.log(value);
  }

  saveUserInput(){
    const playMaster = {
      drawMasterId: this.activeDrawTime.drawId,
      userId: this.user.userId,
    };

    console.log(playMaster);
  }

}
