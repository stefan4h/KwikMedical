import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ViewIncidentPage } from './view-incident-page.component';

const routes: Routes = [
  {
    path: '',
    component: ViewIncidentPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ViewIncidentPageRoutingModule {}
