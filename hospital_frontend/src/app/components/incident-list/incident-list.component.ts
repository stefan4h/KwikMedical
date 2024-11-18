import {Component, Input, OnInit} from '@angular/core';
import {HospitalService} from '../../services/hospital.service';

@Component({
  selector: 'app-incident-list',
  templateUrl: './incident-list.component.html',
  styleUrls: ['./incident-list.component.scss'],
})
export class IncidentListComponent implements OnInit {
  @Input() hospitalId: number | null = null;

  incidents: any[] = [];
  private lastIncidentCount: number = 0;

  constructor(private hospitalService: HospitalService) {
  }

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
}
