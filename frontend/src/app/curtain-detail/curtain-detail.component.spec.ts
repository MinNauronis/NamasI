import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CurtainDetailComponent } from './curtain-detail.component';

describe('CurtainDetailComponent', () => {
  let component: CurtainDetailComponent;
  let fixture: ComponentFixture<CurtainDetailComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CurtainDetailComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CurtainDetailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
