import { Injectable } from '@angular/core';
import {Observable} from "rxjs";
import {HttpClient} from "@angular/common/http";

export interface Message {
  fromName: string;
  subject: string;
  date: string;
  id: number;
  read: boolean;
}

@Injectable({
  providedIn: 'root'
})
export class IncidentService {

  private apiUrl = 'http://127.0.0.1:8003/incidents';

  constructor(private http: HttpClient) {}

  getIncidentsByAmbulanceName(ambulanceName: string): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}?ambulance_name=${ambulanceName}`);
  }

}
