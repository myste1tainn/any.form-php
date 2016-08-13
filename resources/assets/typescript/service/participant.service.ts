import {Injectable} from 'angular2/core';
import {Http, Headers} from 'angular2/http';
import {Config} from '../app.config';
import {Participant} from '../types/participant';

@Injectable()
export class ParticipantService {
	constructor(private _http:Http) {}

	private headers() {
		let headers = new Headers();
		headers.append('Content-Type', 'application/json');
		return headers;
	}

	load(id?:string) {
		if (!!id) {
			return this._http.get(Config.api('participant/'+id));
		} else {
			return this._http.get(Config.api('participants'));
		}
	}

	add(participant: Participant) {
		return this._http.post(
			Config.api('participant'),
			JSON.stringify(participant),
			this.headers()
		);
	}
	update(participant: Participant) {
		return this._http.put(
			Config.api('participant/'+participant.id),
			JSON.stringify(participant),
			this.headers()
		);	
	}
} 