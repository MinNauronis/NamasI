import {Injectable} from '@angular/core';
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {MessageService} from "../message/message.service";
import {Observable, of} from "rxjs";
import {Curtain} from "../objects/curtain";
import {catchError, map, tap} from "rxjs/operators";

const httpOptions = {
    headers: new HttpHeaders({'Content-Type': 'application/json'})
};

@Injectable({
    providedIn: 'root'
})

export class CurtainService {

    //should be global
    private _serveUrl = 'http://localhost:8000/';
    private _curtainsUrl = 'api/curtains/';

    constructor(private _http: HttpClient, private _messageService: MessageService) {

    }

    public getCurtains(): Observable<Curtain[]> {
        this.log('fetch curtains');
        this._http.get(this.getUrl(), httpOptions).subscribe((res) => {
            console.log(res['curtains']);
        })

        return this._http.get(this.getUrl(), httpOptions).pipe(
            map(response => response['curtains']),
            tap(_ => this.log('fetched curtains')),
            catchError(this.handleError('get curtains', []))
        )
    }

    private getUrl(id: number = undefined): string {
        let url = this._serveUrl+this._curtainsUrl;

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
        this._http.get(this.getUrl(id), httpOptions).subscribe(
            curtain => console.log(curtain['curtain'])
        );

        return this._http.get(this.getUrl(id), httpOptions).pipe(
            tap(_ => this.log('fetched curtain')),
            map(response => response['curtain']),
            catchError(this.handleError<Curtain>('getCurtain'))
        );
    }

    public addCurtain(curtain: Curtain): Observable<Curtain> {
        this.log('post curtain');

        return this._http.post<Curtain>(this.getUrl(), curtain, httpOptions).pipe(
            tap((curtain: Curtain) => this.log(`added curtain with name = ${curtain.title}`)),
            catchError(this.handleError<Curtain>('addCurtain'))
        );
    }

    public updateCurtain(curtain: Curtain): Observable<Curtain> {
        this.log('update curtain');

        return this._http.put<Curtain>(this.getUrl(curtain.id), curtain, httpOptions).pipe(
          tap((curtain : Curtain) => this.log(`updated curtain id=${curtain.id}`)),
            catchError(this.handleError<Curtain>('updatedCurtain'))
        );
    }

    public deleteCurtain(curtain: Curtain | number): Observable<Curtain> {
        const id = typeof curtain === 'number' ? curtain : curtain.id;

        return this._http.delete<Curtain>(this.getUrl(id)).pipe(
            tap( _ => this.log(`deleted curtain id${id}`)),
            catchError(this.handleError<Curtain>('deleteCurtain'))
        )
    }
}
