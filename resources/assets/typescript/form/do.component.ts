import {Component, OnInit}		from 'angular2/core';
import {ParticipantInfoFormComponent} from '../participant/info.component';
import {FormDoTableHeaderComponent} from '../form/do-table-header.component';
import {Form}	 				from '../types/form';
import {FormService} 			from '../service/form.service';
import {RouteParams} 			from 'angular2/router';

@Component({
	templateUrl: 'template/form/do',
	providers: [FormService],
	directives: [ParticipantInfoFormComponent, FormDoTableHeaderComponent]
})

export class FormDoComponent implements OnInit {
	form: Form
	constructor(private _formService:FormService, private _rp:RouteParams) {
	}

	ngOnInit() {
		this.loadFormIfNeeded();
	}

	loadFormIfNeeded() {
		if (!!!this.form) {
			let id = this._rp.params['id'];
			this._formService.load(id).subscribe(
			data => {
				this.form = new Form(data);
			},
			error => {
				console.log(error);
			})
		}
	}
}