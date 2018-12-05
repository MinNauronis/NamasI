import {Component, OnInit} from '@angular/core';
import {Hero} from "../hero";
import {ActivatedRoute} from "@angular/router";
import {HeroService} from "../hero.service";
import {Location} from "@angular/common";

@Component({
    selector: 'app-hero-detail',
    templateUrl: './hero-detail.component.html',
    styleUrls: ['./hero-detail.component.css']
})

export class HeroDetailComponent implements OnInit {
    hero: Hero;

    constructor(
        private _route: ActivatedRoute,
        private _heroService: HeroService,
        private _location: Location
    ) {
    }

    ngOnInit() {
        this.getHero();
    }

    private getHero() {
        const id = +this._route.snapshot.paramMap.get('id'); //'+' make id to number
        this._heroService.getHero(id).subscribe(hero => this.hero = hero)
    }

    goBack(): void {
        this._location.back();
    }

    save(): void {
        this._heroService.updateHero(this.hero)
            .subscribe(() => this.goBack());
    }
}
