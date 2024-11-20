import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { IonicModule } from '@ionic/angular';
import { FormsModule } from '@angular/forms';

import { HomePage } from './home.page';
import { HomePageRoutingModule } from './home-routing.module';
import { IncidentComponentModule } from '../incident/incident.module';
import {AmbulanceNamePopupComponent} from "../ambulance-name-popup/ambulance-name-popup.component";
import {provideHttpClient} from "@angular/common/http";
@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    IncidentComponentModule,
    HomePageRoutingModule
  ],
  declarations: [HomePage, AmbulanceNamePopupComponent],
  providers: [provideHttpClient()]
})
export class HomePageModule {}
