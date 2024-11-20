import { CommonModule } from '@angular/common';
import { Component, inject, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { IonicModule, Platform } from '@ionic/angular';
import { IncidentService, Message } from '../services/incident.service';

@Component({
  selector: 'app-view-incident',
  templateUrl: './view-incident-page.component.html',
  styleUrls: ['./view-incident-page.component.scss'],
})
export class ViewIncidentPage implements OnInit {
  public message!: Message;
  private data = inject(IncidentService);
  private activatedRoute = inject(ActivatedRoute);
  private platform = inject(Platform);

  constructor() {}

  ngOnInit() {
    const id = this.activatedRoute.snapshot.paramMap.get('id') as string;
    //this.message = this.data.getMessageById(parseInt(id, 10));
  }

  getBackButtonText() {
    const isIos = this.platform.is('ios')
    return isIos ? 'Inbox' : '';
  }
}
