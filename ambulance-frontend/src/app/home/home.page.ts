import { Component, inject } from '@angular/core';
import { RefresherCustomEvent, ModalController } from '@ionic/angular';
import { IncidentService, Message } from '../services/incident.service';
import { AmbulanceNamePopupComponent } from '../ambulance-name-popup/ambulance-name-popup.component';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {
  private data = inject(IncidentService);
  public ambulanceName: string = 'N11';

  constructor(private modalController: ModalController) {}

  refresh(ev: any) {
    setTimeout(() => {
      (ev as RefresherCustomEvent).detail.complete();
    }, 3000);
  }

  getMessages(): Message[] {
    return this.data.getMessages();
  }

  async openPopup() {
    const modal = await this.modalController.create({
      component: AmbulanceNamePopupComponent,
      componentProps: { ambulanceName: this.ambulanceName },
    });

    await modal.present();

    const { data } = await modal.onWillDismiss();

    if (data !== null) {
      this.ambulanceName = data; // Update the ambulance name with the new value
    }
  }
}
