import { Component } from '@angular/core';
import { IonicPage, NavController, NavParams, ToastController } from 'ionic-angular';
import { TabsPage } from '../tabs/tabs';
import { LoginPage } from '../login/login';
import { AuthServiceProvider } from '../../providers/auth-service/auth-service';
import { FormGroup, Validators, FormBuilder } from '@angular/forms';


@IonicPage()
@Component({
  selector: 'page-signup',
  templateUrl: 'signup.html',
})
export class SignupPage {

	responseData : any;
	public form : FormGroup;
	userData = {"username": "","password": "", "name": "","email": "", "repassword": ""};

  constructor(public navCtrl: NavController, public navParams: NavParams, public authService:AuthServiceProvider, public toastCtrl:ToastController, public fb : FormBuilder) {
  
  this.form = fb.group({
         "nama" 		: ["",Validators.compose([ Validators.minLength(8),Validators.required])],
		 "email"		: ["", Validators.required],
         "username"		: ["",Validators.compose([ Validators.minLength(8),Validators.required])],
		 "password" 	: ["",Validators.compose([ Validators.minLength(8),Validators.required])],
		 "repassword"  	: ["",Validators.compose([ Validators.minLength(8),Validators.required])]	 
      });
      
  
  }
	
    
  ionViewDidLoad() {
    console.log('ionViewDidLoad SignupPage');
  }

signup(){
    if(this.userData.username && this.userData.password && this.userData.email && this.userData.name && this.userData.repassword){
      //Api connections
	if(this.userData.password == this.userData.repassword){
    this.authService.postData(this.userData, "signup").then((result) =>{
    this.responseData = result;
    console.log(this.responseData);
    localStorage.setItem('userData', JSON.stringify(this.responseData) ) 
    this.navCtrl.push(TabsPage);
    }, (err) => {
      //Connection failed message
      this.presentToast("Error");
    });
    
    }else{ this.presentToast("Password Not Match."); }
  }
  else {
    this.presentToast("Give valid information.");
  }
  }
  
  presentToast(msg) {
    let toast = this.toastCtrl.create({
      message: msg,
      duration: 2000
    });
    toast.present();
  }

  login(){
    //Login page link
    this.navCtrl.push(LoginPage);
  }
  

}
