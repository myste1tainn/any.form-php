import {Injectable} from 'angular2/core';
import {Http, Headers} from 'angular2/http';
import {Config} from '../app.config';
import {Form} from '../types/form';

@Injectable()
export class FormService {
	constructor(private _http:Http) {}

	private headers() {
		let headers = new Headers();
		headers.append('Content-Type', 'application/json');
		return headers;
	}

	load(id?:string) {
		if (!!id) {
			return this._http.get(Config.api('form/'+id));
		} else {
			return this._http.get(Config.api('forms'));
		}
	}

	add(form: Form) {
		return this._http.post(
			Config.api('form'),
			JSON.stringify(form),
			this.headers()
		);
	}
	update(form: Form) {
		return this._http.put(
			Config.api('form/'+form.id),
			JSON.stringify(form),
			this.headers()
		);	
	}
} 