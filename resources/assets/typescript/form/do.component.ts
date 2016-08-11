import {Component} 				from 'angular2/core';
import {Form} 					from '../types/form';
import {Participant}			from '../types/participant';
import {DataService}			from '../service/data.service';
@Component({
	templateUrl: 'template/form/do',
	bindings: [DataService]
})
export class FormDoComponent {
	participant: Participant;
	form: Form;
	constructor(private _dataService:DataService) {
		console.log(this._dataService.identifier);
		console.log(this._dataService.data);
	}
}