import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { IncidentService } from '../services/incident.service';

@Component({
  selector: 'app-view-incident',
  templateUrl: './view-incident-page.component.html',
  styleUrls: ['./view-incident-page.component.scss'],
})
export class ViewIncidentPage implements OnInit {
  public incident: any;
  public updatedDetails = {
    what: '',
    when: '',
    where: '',
    actions_taken: '',
    time_on_call: null,
  };

  constructor(
    private incidentService: IncidentService,
    private activatedRoute: ActivatedRoute
  ) {}

  ngOnInit() {
    const id = this.activatedRoute.snapshot.paramMap.get('id') as string;
    this.loadIncident(id);
  }

  private loadIncident(id: string) {
    this.incidentService.getIncidentById(id).subscribe((incident) => {
      this.incident = incident;

      // Prefill fields with existing data
      this.updatedDetails = {
        what: incident.what || '',
        when: incident.when || '',
        where: incident.where || '',
        actions_taken: incident.actions_taken || '',
        time_on_call: incident.time_on_call || null,
      };
    });
  }

  updateIncidentDetails() {
    if (!this.incident) return;

    this.incidentService
      .updateIncidentDetails(this.incident.id, this.updatedDetails)
      .subscribe((updatedIncident) => {
        this.incident = updatedIncident; // Update the view with the latest data
      });
  }

  getBackButtonText() {
    return 'Back';
  }
}
