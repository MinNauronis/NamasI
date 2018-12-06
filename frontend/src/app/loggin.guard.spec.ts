import { TestBed, async, inject } from '@angular/core/testing';

import { LogginGuard } from './loggin.guard';

describe('LogginGuard', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [LogginGuard]
    });
  });

  it('should ...', inject([LogginGuard], (guard: LogginGuard) => {
    expect(guard).toBeTruthy();
  }));
});
