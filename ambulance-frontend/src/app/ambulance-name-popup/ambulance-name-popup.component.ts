import { Component } from '@angular/core';
import { ModalController } from '@ionic/angular';

@Component({
  selector: 'app-ambulance-name-popup',
  template: `
    <ion-header>
      <ion-toolbar>
        <ion-title>Change Ambulance Name</ion-title>
        <ion-buttons slot="end">
          <ion-button (click)="dismiss()">Close</ion-button>
        </ion-buttons>
      </ion-toolbar>
    </ion-header>

    <ion-content>
      <ion-item>
        <ion-label position="floating">Ambulance Name</ion-label>
        <ion-input
          [(ngModel)]="ambulanceName"
          placeholder="Enter new name"
        ></ion-input>
      </ion-item>
      <ion-footer>
        <ion-button expand="full" (click)="save()">Save</ion-button>
      </ion-footer>
    </ion-content>
  `,
  styles: [
    `
      :host {
        display: block;
        height: 100%; /* Make the modal take the full height */
      }

      ion-content {
        --background: transparent; /* Remove black background */
        padding: 16px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
      }

      ion-footer {
        margin-top: auto; /* Ensure the footer is aligned at the bottom */
      }
    `,
  ],
})
export class AmbulanceNamePopupComponent {
  public ambulanceName: string = '';

  constructor(private modalController: ModalController) {}

  dismiss() {
    this.modalController.dismiss(null);
  }

  save() {
    this.modalController.dismiss(this.ambulanceName);
  }
}
