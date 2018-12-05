import {Component, OnInit} from '@angular/core';
import {Observable, Subject} from "rxjs";
import {Hero} from "../hero";
import {HeroService} from "../hero.service";
import {debounceTime, distinctUntilChanged, switchMap} from "rxjs/operators";

@Component({
    selector: 'app-hero-search',
    templateUrl: './hero-search.component.html',
    styleUrls: ['./hero-search.component.css']
})
export class HeroSearchComponent implements OnInit {
    heroes$: Observable<Hero[]>;
    private searchTerms = new Subject<string>();

    constructor(private _heroService: HeroService) {
    }

    ngOnInit(): void {
        this.heroes$ = this.searchTerms.pipe(
            // wait 300ms after each keystroke before considering the term
            debounceTime(300),
            //ensures that a request is sent only if the filter text changed.
            distinctUntilChanged(),
            switchMap((term: string) => this._heroService.searchHeroes(term))
        );
    }

    search(term: string): void {
        this.searchTerms.next(term);
    }

}
