import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ViewIncidentPage } from './view-incident-page.component';

import { IonicModule } from '@ionic/angular';

import { ViewIncidentPageRoutingModule } from './view-incident-routing.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ViewIncidentPageRoutingModule
  ],
  declarations: [ViewIncidentPage]
})
export class ViewIncidentPageModule {}
