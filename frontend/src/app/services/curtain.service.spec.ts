import { TestBed } from '@angular/core/testing';

import { CurtainService } from './curtain.service';

describe('CurtainService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: CurtainService = TestBed.get(CurtainService);
    expect(service).toBeTruthy();
  });
});
