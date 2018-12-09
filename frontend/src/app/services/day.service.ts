import {Injectable} from '@angular/core';
import {Day} from "../objects/day";
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {Observable, of} from 'rxjs';
import {map, tap, catchError} from 'rxjs/operators';
import {HttpOptionsService} from "./http-options.service";

const httpOptions = {
    headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Accept' : 'application/json'
    })
};

@Injectable({
    providedIn: 'root'
})
export class DayService {

    //should be global. / is very important
    private _serverUrl = 'http://localhost:8000/';
    private _daysUrl = 'api/schedules/_slug_/days/';

    constructor(private _http: HttpClient, private _httpOptionsService: HttpOptionsService) {
    }

    public getDays(scheduleId: number): Observable<Day[]> {
        this.log('fetch days');
        let options = this._httpOptionsService.getHttpOptions();

        return this._http.get(this.getUrl(scheduleId), options).pipe(
            map(response => response['days']),
            tap(_ => this.log('fetched days')),
            tap(response => console.log(response)),
            catchError(this.handleError('get days', []))
        )
    }

    private getUrl(slug: number, id: number = undefined): string {
        let url = '';

        url = this._serverUrl + this._daysUrl;
        url = url.replace('_slug_', String(slug));
        if (id != null) {
            url = url + id;
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
        //this._messageService.add(`Day service: ${message}`);
        console.log(`Day service: ${message}`);
    }

    public getDay(scheduleId: number, dayId: number): Observable<Day> {
        this.log('fetch day started');
        let options = this._httpOptionsService.getHttpOptions();

        return this._http.get(this.getUrl(scheduleId, dayId), options).pipe(
            tap(_ => this.log('fetched day')),
            tap(day => console.log(day['day'])),
            map(response => response['day']),
            catchError(this.handleError<Day>('getDay'))
        );
    }

    public updateDay(scheduleId: number, day: Day): Observable<Day> {
        this.log('update day');
        let options = this._httpOptionsService.getHttpOptions();

        return this._http.put<Day>(this.getUrl(scheduleId, day.id), day, options).pipe(
            tap((day: Day) => this.log(`updated day id=${day}`)),
            catchError(this.handleError<Day>('updatedDay'))
        );
    }
}
