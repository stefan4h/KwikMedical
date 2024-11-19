import { Component, Input, OnInit } from '@angular/core';
import { HospitalService } from '../../services/hospital.service';
import { IncidentService } from '../../services/incident.service';

@Component({
  selector: 'app-incident-list',
  templateUrl: './incident-list.component.html',
  styleUrls: ['./incident-list.component.scss'],
})
export class IncidentListComponent implements OnInit {
  @Input() hospitalId: number | null = null;

  incidents: any[] = [];
  private lastIncidentCount: number = 0;

  constructor(
    private hospitalService: HospitalService,
    private incidentService: IncidentService
  ) {}

  ngOnInit(): void {
    setInterval(() => {
      if (this.hospitalId === null) return;
      this.hospitalService.getHospitals().subscribe((hospitals) => {
        const selectedHospital = hospitals.find(
          (hospital) => hospital.id === Number(this.hospitalId)
        );

        if (
          selectedHospital &&
          selectedHospital.incidents.length !== this.lastIncidentCount
        ) {
          this.incidents = selectedHospital.incidents;
          this.lastIncidentCount = selectedHospital.incidents.length;
        }
      });
    }, 2000);
  }

  completeIncident(incidentId: number): void {
    this.incidentService.completeIncident(incidentId).subscribe({
      next: () => {
        this.lastIncidentCount = 0;
      },
      error: (err) => {
        alert(`Failed to complete the incident: ${err.message}`);
      },
    });
  }
}
