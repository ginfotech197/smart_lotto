import {Component, OnInit, Renderer2} from '@angular/core';
import {TerminalReportService} from '../../services/terminal-report.service';
import {User} from '../../models/user.model';
import {CPanelBarcodeReport} from '../../models/CPanelBarcodeReport.model';
import {TerminalBarcodeReport} from '../../models/TerminalBarcodeReport.model';
import {DatePipe} from '@angular/common';
import {TerminalSaleReport} from '../../models/TerminaSaleReport.model';
import Swal from 'sweetalert2';
import {AdminReportService} from '../../services/admin-report.service';
import {BarcodeDetails} from '../../models/BarcodeDetails.model';
import {AuthService} from '../../services/auth.service';
import {CommonService} from '../../services/common.service';


@Component({
  selector: 'app-terminal-report',
  templateUrl: './terminal-report.component.html',
  styleUrls: ['./terminal-report.component.scss']
})
export class TerminalReportComponent implements OnInit {

  thisYear = new Date().getFullYear();
  thisMonth = new Date().getMonth();
  thisDay = new Date().getDate();
  startDate = new Date(this.thisYear, this.thisMonth, this.thisDay);
  StartDateFilter = this.startDate;
  EndDateFilter = this.startDate;
  barcodeDetails: BarcodeDetails;
  pipe = new DatePipe('en-US');
  selectedIndex: number;
  columnNumber = 5;

  terminalReportData: TerminalBarcodeReport[] = [];
  terminalSaleReportData: TerminalSaleReport[] = [];
  cardTerminalSaleReportData: TerminalSaleReport[] = [];

  // tslint:disable-next-line:max-line-length
  constructor( private renderer: Renderer2, private terminalReportService: TerminalReportService, private adminReportService: AdminReportService,
               private commonService: CommonService) {
    this.renderer.setStyle(document.body, 'background-image', 'none');

    this.terminalReportService.terminalListListener().subscribe((response) => {
      this.terminalReportData = response;
    });
    this.terminalReportService.terminalSaleListListener().subscribe((response) => {
      this.terminalSaleReportData = response;
    });
    this.terminalReportService.cardTerminalSaleListListener().subscribe((response) => {
      this.cardTerminalSaleReportData = response;
    });
    this.getTerminalBarcodeReport();
    this.getTerminalSaleReport();

    this.commonService.terminalCancelListListener().subscribe((response) => {
      // tslint:disable-next-line:only-arrow-functions
      response.forEach(function(value){
          const z = this.terminalReportData.findIndex(x => x.play_master_id === value.id);
          this.terminalReportData[z].is_cancelable = 0;
      });
    });
  }

  ngOnInit(): void {
    // this.terminalReport.getTerminalReport();
  }

  claimPrize(play_master_id){
    Swal.fire({
      title: 'Please Wait !',
      html: 'adding points ...', // add html attribute if you want or remove
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });
    this.terminalReportService.claimPrize(play_master_id).subscribe((response) => {
      if (response.point){
        Swal.close();
      }
    });
  }

  checkBtnEligibility(record){
    if (record.is_cancelled === 1){
      return true;
    }
    if (record.is_cancelable === 0){
      return true;
    }
    return false;
  }

  cancelTicket(masterId){
    Swal.fire({
      title: 'Confirm Cancel ?',
      // showDenyButton: true,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: `Yes, confirm`,
      // denyButtonText: `Don't save`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Please Wait !',
          html: 'Confirming cancel', // add html attribute if you want or remove
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });
        this.terminalReportService.cancelTicket(masterId).subscribe((response) => {
          if (response.success === 1){
          // if(response.data){
            Swal.hideLoading();
            Swal.fire({
              icon: 'success',
              title: 'Cancelled',
              showConfirmButton: false,
              timer: 1500
            });
          }else{
            Swal.fire({
              icon: 'error',
              title: 'You cannot cancel this ticket',
              showConfirmButton: false,
              timer: 2000
            });
          }
        });
      } else if (result.isDenied) {
        Swal.fire('Changes are not saved', '', 'info');
      }
    });
  }

  getTerminalBarcodeReport(){
    Swal.fire({
      title: 'Please Wait !',
      html: 'loading ...', // add html attribute if you want or remove
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });
    const User = JSON.parse(localStorage.getItem('user'));
    let startDate = this.pipe.transform(this.StartDateFilter, 'yyyy-MM-dd');
    let endDate = this.pipe.transform(this.EndDateFilter, 'yyyy-MM-dd');
    this.terminalReportService.getTerminalReport(User.userId, startDate, endDate).subscribe((response) => {
      if (response.data){
        Swal.close();
      }
    });
  }

  getTerminalSaleReport(){
    Swal.fire({
      title: 'Please Wait !',
      html: 'loading ...', // add html attribute if you want or remove
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      }
    });
    const User = JSON.parse(localStorage.getItem('user'));
    const startDate = this.pipe.transform(this.StartDateFilter, 'yyyy-MM-dd');
    const endDate = this.pipe.transform(this.EndDateFilter, 'yyyy-MM-dd');
    this.terminalReportService.getTerminalSaleReport(User.userId, startDate, endDate).subscribe((response) => {
      if (response.data){
        Swal.close();
      }
    });
    this.terminalReportService.getCardTerminalSaleReport(User.userId, startDate, endDate).subscribe((response) => {
      if (response.data){
        Swal.close();
      }
    });
  }

  openPopup(playMasterId: number, barcodeNumber: string){

    this.adminReportService.getBarcodeDetails(playMasterId).subscribe(response => {
      this.barcodeDetails = response.data;
      //console.log(this.barcodeDetails);
    });
  }

}
