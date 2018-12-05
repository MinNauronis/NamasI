import {Injectable} from '@angular/core';
import {Hero} from "./hero";
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {Observable, of} from "rxjs";
import {MessageService} from "./message/message.service";
import {catchError, map, tap} from "rxjs/operators";

const httpOptions = {
    headers: new HttpHeaders({'Content-Type': 'application/json'})
};

@Injectable({
    providedIn: 'root'
})
export class HeroService {

    private _heroesUrl = 'api/heroes';  // URL to web api

    constructor(private _http: HttpClient, private _messageService: MessageService) {
    }

    getHeroes(): Observable<Hero[]> {
        this._messageService.add('HeroService: fetched heroes');
        return this._http.get<Hero[]>(this._heroesUrl)
            .pipe(
                tap(_ => this.log('fetched heroes')),
                catchError(this.handleError('getHeroes', []))
            );
    }

    /**
     * Handle Http operation that failed.
     * Let the app continue.
     * @param operation - name of the operation that failed
     * @param result - optional value to return as the observable result
     */
    private handleError<T>(operation = 'operation', result?: T) {
        return (error: any): Observable<T> => {

            // TODO: send the error to remote logging infrastructure
            console.error(error); // log to console instead

            // TODO: better job of transforming error for user consumption
            this.log(`${operation} failed: ${error.message}`);

            // Let the app keep running by returning an empty result.
            return of(result as T);
        };
    }

    getHero(id: number): Observable<Hero> {
        const url = `${this._heroesUrl}/${id}`;
        return this._http.get<Hero>(url).pipe(
            tap(_ => this.log(`fetched hero id=${id}`)),
            catchError(this.handleError<Hero>(`getHero id=${id}`))
        );
    }

    /** PUT: update the hero on the server */
    updateHero(hero: Hero): Observable<any> {
        return this._http.put(this._heroesUrl, hero, httpOptions).pipe(
            tap(_ => this.log(`updated hero id=${hero.id}`)),
            catchError(this.handleError<any>('updateHero'))
        );
    }

    addHero(hero: Hero): Observable<Hero> {
        return this._http.post<Hero>(this._heroesUrl, hero, httpOptions).pipe(
            tap((hero: Hero) => this.log(`added hero w/ id=${hero.id}`)),
            catchError(this.handleError<Hero>('addHero'))
        )
    }

    deleteHero(hero: Hero | number): Observable<Hero> {
        const id = typeof hero === 'number' ? hero : hero.id;
        const url = `${this._heroesUrl}/${id}`;

        return this._http.delete<Hero>(url,httpOptions).pipe(
            tap(_ => this.log(`deleted hero id=${id}`)),
            catchError(this.handleError<Hero>('deleteHero'))
        );
    }

    searchHeroes(term: string): Observable<Hero[]> {
        if(!term.trim()) {
            return of([])
        }

        return this._http.get<Hero[]>(`${this._heroesUrl}/?name=${term}`).pipe(
            tap(_ => this.log(`found heroes matching "${term}"`)),
            catchError(this.handleError<Hero[]>('searchHeroes', []))
        );
    }

    private log(message: string) {
        this._messageService.add(`HeroService: ${message}`);
    }
}
