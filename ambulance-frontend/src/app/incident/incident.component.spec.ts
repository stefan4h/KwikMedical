import { ComponentFixture, TestBed } from '@angular/core/testing';
import { RouterModule } from '@angular/router';
import { IonicModule } from '@ionic/angular';

import { IncidentComponent } from './incident.component';

describe('MessageComponent', () => {
  let component: IncidentComponent;
  let fixture: ComponentFixture<IncidentComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [IncidentComponent],
      imports: [IonicModule.forRoot(), RouterModule.forRoot([])]
    }).compileComponents();

    fixture = TestBed.createComponent(IncidentComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
