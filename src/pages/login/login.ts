import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, ToastController } from 'ionic-angular';
import { TabsPage } from '../tabs/tabs';
import { SignupPage } from '../signup/signup';
import { AuthServiceProvider } from '../../providers/auth-service/auth-service';

@IonicPage()
@Component({
  selector: 'page-login',
  templateUrl: 'login.html',
})
export class LoginPage {
responseData : any;
	userData = {"username": "","password": "", "name": "","email": ""};
  constructor(public navCtrl: NavController, public navParams: NavParams, public authService:AuthServiceProvider,private toastCtrl:ToastController) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad LoginPage');
  }
  
  login(){
   if(this.userData.username && this.userData.password){
    this.authService.postData(this.userData, "login").then((result) =>{
    this.responseData = result;
    console.log(this.responseData);
    if(this.responseData.userData){
     localStorage.setItem('userData', JSON.stringify(this.responseData) )
    this.navCtrl.push(TabsPage);
  }
  else{
    this.presentToast("Please give valid username and password");
  }
       }, (err) => {
      //Connection failed message
      this.presentToast("Error");
    });
   }
   else{
    this.presentToast("Give username and password");
   }
  
  }
   
signup(){  this.navCtrl.push(SignupPage); }

 presentToast(msg) {
    let toast = this.toastCtrl.create({
      message: msg,
      duration: 2000
    });
    toast.present();
  }
}
