import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import {Observable, Subject} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class EmergencyService {
  private apiUrl = 'http://127.0.0.1:8001/emergencies';
  private reloadSubject = new Subject<void>();

  constructor(private http: HttpClient) {}

  getAllEmergencies(): Observable<any[]> {
    return this.http.get<any[]>(this.apiUrl);
  }

  createEmergency(emergencyData: any): Observable<any> {
    return this.http.post<any>(this.apiUrl, emergencyData);
  }

  triggerReload(): void {
    this.reloadSubject.next();
  }

  getReloadListener(): Observable<void> {
    return this.reloadSubject.asObservable();
  }
}
