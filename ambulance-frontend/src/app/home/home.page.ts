import { Component, inject, OnInit, OnDestroy } from '@angular/core';
import { RefresherCustomEvent, ModalController } from '@ionic/angular';
import { IncidentService } from '../services/incident.service';
import { AmbulanceNamePopupComponent } from '../ambulance-name-popup/ambulance-name-popup.component';
import { BehaviorSubject, interval, Subscription, switchMap } from 'rxjs';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage implements OnInit, OnDestroy {
  private incidentService = inject(IncidentService);
  public ambulanceName: string = 'N11';
  public incidents: any[] = [];
  private ambulanceNameSubject = new BehaviorSubject<string>(this.ambulanceName);
  private pollingSubscription: Subscription | null = null;

  constructor(private modalController: ModalController) {}

  ngOnInit(): void {
    this.startPolling();
  }

  ngOnDestroy(): void {
    this.stopPolling();
  }

  refresh(ev: any) {
    setTimeout(() => {
      (ev as RefresherCustomEvent).detail.complete();
    }, 3000);
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
      this.ambulanceNameSubject.next(this.ambulanceName); // Trigger incident reload
      this.restartPolling(); // Restart polling with the updated ambulance name
    }
  }

  private startPolling(): void {
    this.pollingSubscription = this.ambulanceNameSubject
      .pipe(
        switchMap((ambulanceName) =>
          interval(1000).pipe(
            switchMap(() =>
              this.incidentService.getIncidentsByAmbulanceName(ambulanceName)
            )
          )
        )
      )
      .subscribe((newIncidents) => {
        this.incidents = newIncidents;
      });
  }

  private stopPolling(): void {
    if (this.pollingSubscription) {
      this.pollingSubscription.unsubscribe();
      this.pollingSubscription = null;
    }
  }

  private restartPolling(): void {
    this.stopPolling();
    this.startPolling();
  }
}
