import { Component, OnInit } from '@angular/core';
import {WatchDrawService} from "../../services/watch-draw.service";
import {LastResult} from "../../models/LastResult.model";

@Component({
  selector: 'app-current-result',
  templateUrl: './current-result.component.html',
  styleUrls: ['./current-result.component.scss']
})
export class CurrentResultComponent implements OnInit {

  lastResult: LastResult[];

  constructor(private watchDrawService: WatchDrawService) {

    this.watchDrawService.lastResultSubject.subscribe((response) => {
      this.lastResult = response;
      // console.log('current result', this.lastResult);
    });
  }

  ngOnInit(): void {
  }

}
