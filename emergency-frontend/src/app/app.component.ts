import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import {EmergencyListComponent} from './emergency-list/emergency-list.component';
import {EmergencyFormComponent} from './emergency-form/emergency-form.component';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, EmergencyListComponent, EmergencyFormComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.scss'
})
export class AppComponent {
  title = 'emergency-frontend';
}
