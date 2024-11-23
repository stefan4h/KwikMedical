import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class IncidentService {
  private apiUrl = 'http://127.0.0.1:8003/incidents';

  constructor(private http: HttpClient) {}

  getIncidentById(id: string): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/${id}`);
  }

  updateIncidentDetails(id: string, details: any): Observable<any> {
    return this.http.patch<any>(`${this.apiUrl}/${id}/details`, details);
  }

  getIncidentsByAmbulanceName(ambulanceName: string): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}?ambulance_name=${ambulanceName}`);
  }
}
