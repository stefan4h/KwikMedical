import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { IonicModule } from '@ionic/angular';
import { FormsModule } from '@angular/forms';

import { HomePage } from './home.page';
import { HomePageRoutingModule } from './home-routing.module';
import { MessageComponentModule } from '../message/message.module';
import {AmbulanceNamePopupComponent} from "../ambulance-name-popup/ambulance-name-popup.component";

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MessageComponentModule,
    HomePageRoutingModule,
  ],
  declarations: [HomePage, AmbulanceNamePopupComponent]
})
export class HomePageModule {}
