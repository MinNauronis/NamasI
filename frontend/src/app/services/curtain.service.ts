import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {Observable, of} from "rxjs";
import {Curtain} from "../objects/curtain";
import {catchError, map, tap} from "rxjs/operators";
import {HttpOptionsService} from "./http-options.service";

const httpOptions = {
    headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    })
};

@Injectable({
    providedIn: 'root'
})

export class CurtainService {

    //should be global
    private _serverUrl = 'http://localhost:8000/';
    private _curtainsUrl = 'api/curtains/';

    constructor(private _http: HttpClient, private _httpOptionsService: HttpOptionsService) {

    }

    public getCurtains(): Observable<Curtain[]> {
        this.log('fetch curtains');
        let options = this._httpOptionsService.getHttpOptions();

        return this._http.get(this.getUrl(), options).pipe(
            map(response => response['curtains']),
            tap(_ => this.log('fetched curtains')),
            tap((res) => console.log(res['curtains'])),
            catchError(this.handleError('get curtains', []))
        )
    }

    private getUrl(id: number = undefined): string {
        let url = this._serverUrl + this._curtainsUrl;

        if (id != null) {
            url = `${url}${id}`;
        }

        return url;
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

    private log(message: string): void {
        //this._messageService.add(`Curtain service: ${message}`);
        console.log(`Curtain service: ${message}`);
    }

    public getCurtain(id: number): Observable<Curtain> {
        this.log('fetch curtain started');
        let options = this._httpOptionsService.getHttpOptions();

        return this._http.get(this.getUrl(id), options).pipe(
            tap(_ => this.log('fetched curtain')),
            tap(curtain => console.log(curtain['curtain'])),
            map(response => response['curtain']),
            catchError(this.handleError<Curtain>('getCurtain'))
        );
    }

    public addCurtain(curtain: Curtain): Observable<Curtain> {
        this.log('post curtain');
        let options = this._httpOptionsService.getHttpOptions();

        return this._http.post<Curtain>(this.getUrl(), curtain, options).pipe(
            map(response => response['curtain']),
            tap((curtain: Curtain) => this.log(`added curtain with name = ${curtain.title}`)),
            catchError(this.handleError<Curtain>('addCurtain'))
        );
    }

    public updateCurtain(curtain: Curtain): Observable<Curtain> {
        this.log('update curtain');
        let options = this._httpOptionsService.getHttpOptions();

        return this._http.put<Curtain>(this.getUrl(curtain.id), curtain, options).pipe(
            map(response => response['curtain']),
            tap((curtain: Curtain) => this.log(`updated curtain id=${curtain.id}`)),
            catchError(this.handleError<Curtain>('updatedCurtain'))
        );
    }

    public deleteCurtain(curtain: Curtain | number): Observable<Curtain> {
        const id = typeof curtain === 'number' ? curtain : curtain.id;
        let options = this._httpOptionsService.getHttpOptions();

        return this._http.delete<Curtain>(this.getUrl(id), options).pipe(
            map(response => response['curtain']),
            tap(_ => this.log(`deleted curtain id${id}`)),
            catchError(this.handleError<Curtain>('deleteCurtain'))
        )
    }
}
