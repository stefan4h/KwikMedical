import { ChangeDetectionStrategy, Component, inject, Input } from '@angular/core';
import { Platform } from '@ionic/angular';
import { Message } from '../services/incident.service';

@Component({
  selector: 'app-incident',
  templateUrl: './incident.component.html',
  styleUrls: ['./incident.component.scss'],
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class IncidentComponent {
  private platform = inject(Platform);
  @Input() incident: any;
  isIos() {
    return this.platform.is('ios')
  }
}
