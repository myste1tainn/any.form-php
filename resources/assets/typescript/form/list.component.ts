import {Component} 				from 'angular2/core';
import {FormService} 			from '../service/form.service';
import {DataService} 			from '../service/data.service';
import {Form} 					from '../types/form';
import {Router, ROUTER_DIRECTIVES} from 'angular2/router';

@Component({
	templateUrl: 'template/form/list',
	bindings: [FormService, Router, DataService],
	directives: [ROUTER_DIRECTIVES]
})
export class FormListComponent {
	formList: Form[];

	constructor(private _formService:FormService, private _dataService:DataService, private _router:Router) {
		this._formService.load()
		.subscribe((loadedForms) => {
			this.formList = loadedForms;
		});
	}

	// select(form: Form) {
	// 	this._dataService.identifier = 'DoForm';
	// 	this._dataService.data = form;
	// 	this._router.navigate(['Form', {id:form.id}]);
	// }

}