import { Component } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { EmergencyService } from '../emergency.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-emergency-form',
  templateUrl: './emergency-form.component.html',
  standalone: true,
  imports: [
    ReactiveFormsModule,
    CommonModule,
  ],
  styleUrls: ['./emergency-form.component.scss']
})
export class EmergencyFormComponent {
  emergencyForm: FormGroup;

  // Predefined options for region and type
  regions = ['North', 'South', 'East', 'West'];
  types = ['Heart Attack', 'Stroke', 'Accident', 'Fire', 'Poison'];

  constructor(
    private fb: FormBuilder,
    private emergencyService: EmergencyService,
    private router: Router
  ) {
    this.emergencyForm = this.fb.group({
      caller_name: ['', [Validators.required, Validators.maxLength(255)]],
      caller_phone: ['', [Validators.maxLength(255)]],
      nhs_registration_number: ['', [Validators.required, Validators.maxLength(255)]],
      location: ['', [Validators.required, Validators.maxLength(255)]],
      region: ['', [Validators.required]], // Changed to required without max length
      type: ['', [Validators.required]], // Changed to required without max length
      description: ['', [Validators.maxLength(1000)]],
    });
  }

  onSubmit(): void {
    if (this.emergencyForm.valid) {
      this.emergencyService.createEmergency(this.emergencyForm.value).subscribe({
        next: () => {
          this.emergencyService.triggerReload();
          this.emergencyForm.reset();
        },
        error: (err) => {
          window.alert(`Failed to create the emergency: ${err.error?.message || 'Unknown error occurred'}`);
        },
      });
    } else {
      window.alert('The provided NHS Registration Number does not exist in the System.');
    }
  }
}
