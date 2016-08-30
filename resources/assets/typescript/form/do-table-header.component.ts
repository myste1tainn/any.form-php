import {Component, OnInit, Input} from 'angular2/core';
import {FormDoTableHeader}	 	from '../types/form';
import {RouteParams} 			from 'angular2/router';

@Component({
	selector: '[form-do-table-header]',
	templateUrl: 'template/form/do-table-header',
})

export class FormDoTableHeaderComponent implements OnInit {
	@Input() header: FormDoTableHeader;
	constructor() {}

	ngOnInit() {
		console.log('after');
		for (var i = this.header.rows.length - 1; i >= 0; i--) {
			console.log(this.header.rows[i]);
		}
	}
}