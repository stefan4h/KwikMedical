import {Component, EventEmitter, OnInit, Output} from '@angular/core';
import {HospitalService} from '../../services/hospital.service';

@Component({
  selector: 'app-hospital-list',
  templateUrl: './hospital-list.component.html',
  styleUrl: './hospital-list.component.scss'
})
export class HospitalListComponent implements OnInit {
  hospitals: any[] = [];
  selectedHospitalId: number | undefined = undefined;

  @Output() hospitalSelected = new EventEmitter<number>();

  constructor(private hospitalService: HospitalService) {}

  ngOnInit(): void {
    this.hospitalService.getHospitals().subscribe((hospitals:any[]) => {
      this.hospitals = hospitals;
    });
  }

  onSelectHospital(): void {
    this.hospitalSelected.emit(this.selectedHospitalId);
  }
}
