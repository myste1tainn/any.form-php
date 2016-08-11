import {Http, Headers} from 'angular2/http';
import {Participant} from '../types/participant';

export class ParticipantService {

	constructor(private _http:Http) {}

	load(id:string) {
		let url = 'api/v1/participants'+ ((id) ? '/'+id : '');
		return this._http.get(url);
	}

	add(participant:Participant) {
		let headers = new Headers();
		let url = 'api/v1/participants';
		let body = JSON.stringify(participant);
		return this._http.post(url, body, headers);
	}

	update(participant:Participant) {
		let headers = new Headers();
		let url = 'api/v1/participants';
		let body = JSON.stringify(participant);
		return this._http.post(url, body, headers);
	}

	delete(id:string) {
		let url = 'api/v1/participants/'+id;
		return this._http.delete(url);
	}
}