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
  private incidentService = inject(IncidentService);
  public ambulanceName: string = 'N11';
  public incidents: any[] = [];
  private lastIncidentCount: number = 0;

  constructor(private modalController: ModalController) {}

  ngOnInit(): void {
    this.startPolling();
  }

  refresh(ev: any) {
    setTimeout(() => {
      (ev as RefresherCustomEvent).detail.complete();
    }, 3000);
  }

  getIncidents(): any[] {
    return this.incidents;
  }

  async openPopup() {
    const modal = await this.modalController.create({
      component: AmbulanceNamePopupComponent,
      componentProps: { ambulanceName: this.ambulanceName },
    });

    await modal.present();

    const { data } = await modal.onWillDismiss();

    if (data !== null) {
      this.ambulanceName = data;
      this.startPolling();
    }
  }

  private startPolling(): void {
    setInterval(() => {
      this.incidentService
        .getIncidentsByAmbulanceName(this.ambulanceName)
        .subscribe((newIncidents) => {
          if (newIncidents.length !== this.lastIncidentCount) {
            const newIncidentIds = newIncidents.map((i) => i.id);
            const currentIncidentIds = this.incidents.map((i) => i.id);

            const hasNewIncidents = newIncidentIds.some(
              (id) => !currentIncidentIds.includes(id)
            );

            if (hasNewIncidents) {
              this.incidents = newIncidents;
              this.lastIncidentCount = newIncidents.length;
            }
          }
        });
    }, 2000);
  }
}
