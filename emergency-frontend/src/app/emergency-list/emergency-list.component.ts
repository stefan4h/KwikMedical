import { Component, OnInit } from '@angular/core';
import { EmergencyService } from '../emergency.service';
import {CommonModule} from '@angular/common';
import {Subscription} from 'rxjs';

@Component({
  selector: 'app-emergency-list',
  templateUrl: './emergency-list.component.html',
  styleUrls: ['./emergency-list.component.scss'],
  standalone: true,
  imports: [CommonModule],
})
export class EmergencyListComponent implements OnInit {
  emergencies: any[] = [];
  loading: boolean = true;
  error: string | null = null;
  private reloadSubscription: Subscription;

  constructor(private emergencyService: EmergencyService) {}

  ngOnInit(): void {
    this.fetchEmergencies();

    // Listen for reload events
    this.reloadSubscription = this.emergencyService.getReloadListener().subscribe(() => {
      this.fetchEmergencies();
    });
  }

  fetchEmergencies(): void {
    this.loading = true;
    this.emergencyService.getAllEmergencies().subscribe({
      next: (data) => {
        this.emergencies = data.reverse();
        this.loading = false;
      },
      error: () => {
        this.error = 'Failed to load emergencies. Please try again.';
        this.loading = false;
      }
    });
  }

  ngOnDestroy(): void {
    if (this.reloadSubscription) {
      this.reloadSubscription.unsubscribe();
    }
  }
}
