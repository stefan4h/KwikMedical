import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { provideAnimationsAsync } from '@angular/platform-browser/animations/async';
import { HospitalListComponent } from './components/hospital-list/hospital-list.component';
import { IncidentListComponent } from './components/incident-list/incident-list.component';
import {FormsModule} from '@angular/forms';
import {provideHttpClient} from '@angular/common/http';

@NgModule({
  declarations: [
    AppComponent,
    HospitalListComponent,
    IncidentListComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule
  ],
  providers: [
    provideAnimationsAsync(),
    provideHttpClient()
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
