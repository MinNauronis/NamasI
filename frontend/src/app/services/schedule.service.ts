import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {Observable, of} from "rxjs";
import {Schedule} from "../objects/schedule";
import {catchError, map, tap} from "rxjs/operators";

const httpOptions = {
    headers: new HttpHeaders({
        'Content-Type': 'application/json',
        'Accept' : 'application/json'
    })
};

@Injectable({
    providedIn: 'root'
})
export class ScheduleService {

    //should be global. / is very important
    private _serverUrl = 'http://localhost:8000/';
    private _schedulesUrl = 'api/curtains/_slug_/schedules/';

    constructor(private _http: HttpClient) {
    }

    public getSchedules(curtainId: number): Observable<Schedule[]> {
        this.log('fetch schedules');
        this._http.get(this.getUrl(curtainId), httpOptions).subscribe((res) => {
            console.log(res['schedules']);
        })

        return this._http.get(this.getUrl(curtainId), httpOptions).pipe(
            map(response => response['schedules']),
            tap(_ => this.log('fetched schedules')),
            catchError(this.handleError('get schedules', []))
        )
    }

    private getUrl(slug: number, id: number = undefined): string {
        let url = '';

        url = this._serverUrl + this._schedulesUrl;
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
        //this._messageService.add(`Schedule service: ${message}`);
        console.log(`Schedule service: ${message}`);
    }

    public getSchedule(curtainId: number, scheduleId: number): Observable<Schedule> {
        this.log('fetch schedule started');
        this._http.get(this.getUrl(curtainId, scheduleId), httpOptions).subscribe(
            schedule => console.log(schedule['schedule'])
        );

        return this._http.get(this.getUrl(curtainId, scheduleId), httpOptions).pipe(
            tap(_ => this.log('fetched schedule')),
            map(response => response['schedule']),
            catchError(this.handleError<Schedule>('getSchedule'))
        );
    }

    public addSchedule(curtainId: number, schedule: Schedule): Observable<Schedule> {
        this.log('post schedule');

        return this._http.post<Schedule>(this.getUrl(curtainId), schedule, httpOptions).pipe(
            map(response => response['schedule']),
            tap((schedule: Schedule) => this.log(`added schedule with name = ${schedule.title}`)),
            catchError(this.handleError<Schedule>('addSchedule'))
        );
    }

    public updateSchedule(curtainId: number, schedule: Schedule): Observable<Schedule> {
        this.log('update schedule');

        return this._http.put<Schedule>(this.getUrl(curtainId, schedule.id), schedule, httpOptions).pipe(
            map(response => response['schedule']),
            tap((schedule: Schedule) => this.log(`updated schedule id=${schedule.id}`)),
            catchError(this.handleError<Schedule>('updatedSchedule'))
        );
    }

    public deleteSchedule(curtainId: number, schedule: Schedule | number): Observable<Schedule> {
        const id = typeof schedule === 'number' ? schedule : schedule.id;
        this.log('delete schedule');

        return this._http.delete<Schedule>(this.getUrl(curtainId, id)).pipe(
            map(response => response['schedule']),
            tap(_ => this.log(`deleted schedule ${id}`)),
            catchError(this.handleError<Schedule>('deleteSchedule'))
        )
    }
}