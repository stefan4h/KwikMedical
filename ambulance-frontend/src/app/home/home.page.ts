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
  private gpsUpdateSubscription: Subscription | null = null;
  private simulatedGpsLocation = { lat: 40.712776, lng: -74.005974 }; // Initial coordinates

  constructor(private modalController: ModalController) {}

  ngOnInit(): void {
    this.startPolling();
    this.startGpsUpdates();
  }

  ngOnDestroy(): void {
    this.stopPolling();
    this.stopGpsUpdates();
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
      this.ambulanceNameSubject.next(this.ambulanceName);
      this.restartPolling();
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

  private startGpsUpdates(): void {
    this.gpsUpdateSubscription = interval(10000).subscribe(() => {
      this.simulatedGpsLocation.lat += Math.random() * 0.01 - 0.005;
      this.simulatedGpsLocation.lng += Math.random() * 0.01 - 0.005;

      const gpsLocation = `${this.simulatedGpsLocation.lat.toFixed(
        6
      )},${this.simulatedGpsLocation.lng.toFixed(6)}`;

      this.incidentService
        .updateAmbulanceGpsLocation(this.ambulanceName, gpsLocation)
        .subscribe({
          next: () => console.log('GPS location updated:', gpsLocation),
          error: (err) => console.error('Error updating GPS:', err),
        });
    });
  }

  private stopGpsUpdates(): void {
    if (this.gpsUpdateSubscription) {
      this.gpsUpdateSubscription.unsubscribe();
      this.gpsUpdateSubscription = null;
    }
  }
}
