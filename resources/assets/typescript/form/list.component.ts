import {Component, OnInit}		from 'angular2/core';
import {FormService}			from '../service/form.service';
import {Form}					from '../types/form';
import {ROUTER_PROVIDERS, ROUTER_DIRECTIVES, RouteConfig} from 'angular2/router';

@Component({
	templateUrl: 'template/form/list',
	providers: [FormService],
	directives: [ROUTER_DIRECTIVES]
})
export class FormListComponent implements OnInit {
	forms: Array<Form>;
	constructor(private _service:FormService) {}

	ngOnInit() {
		this._service.load()
		.subscribe(data => {
			this.forms = data.json();
		})
	}
}