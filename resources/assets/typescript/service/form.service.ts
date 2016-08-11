import {Injectable} 				from 'angular2/core';
import {Http, Headers} 				from 'angular2/http';
import {Form}		 				from '../types/form';
import {Observable} 				from 'rxjs/Rx';
import 'rxjs/operator/map';

@Injectable()
export class FormService {

	constructor(private _http:Http) {}
	handleErrors(error: any) {
	    console.log(JSON.stringify(error));
	    return Observable.throw(error);
	}

	load(id?:string) {
		let url = 'api/v1/forms'+ ((id) ? '/'+id : '');
		return this._http.get(url)
		.map(res => res.json())
		.map(data => {
			let formList = [];
			data.forEach((form) => {
				formList.push(new Form(form));
			})
			return formList;
		})
		.catch(this.handleErrors);
	}

	add(form: Form) {
		let headers = new Headers();
		let url = 'api/v1/forms';
		let body = JSON.stringify(form);
		return this._http.post(url, body, headers);
	}
	update(form: Form) {
		let headers = new Headers();
		let url = 'api/v1/forms';
		let body = JSON.stringify(form);
		return this._http.post(url, body, headers);
	}

	delete(id: string) {
		let url = 'api/v1/forms/'+id;
		return this._http.delete(url);
	}

}