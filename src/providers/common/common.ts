import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';
import { LoadingController } from 'ionic-angular';


@Injectable()
export class CommonProvider {
public loader: any;
  constructor(public http: Http,public loadingCtrl: LoadingController) {
    console.log('Hello CommonProvider Provider');
  }
  
  presentLoading(){
   this.loader = this.loadingCtrl.create({content: "Please wait ..."})
  this.loader.present();
  }

  closeLoading(){
  this.loader.dismiss();
  }

}
