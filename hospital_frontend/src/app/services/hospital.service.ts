import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class HospitalService {
  private apiUrl = 'http://127.0.0.1:8003/hospitals';

  constructor(private http: HttpClient) {}

  getHospitals(): Observable<any[]> {
    return this.http.get<any[]>(this.apiUrl);
  }
}
