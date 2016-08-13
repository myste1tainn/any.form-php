import {Response} from 'angular2/Http';

export class Form {
	id: string
	name: string
	header: string
	level: number

	constructor(data:Response) {
		let parsedObject = data.json();
		this.id 	= parsedObject.id;
		this.name 	= parsedObject.name;
		this.header = parsedObject.header;
		this.level 	= parsedObject.level;
	}

	headerObject() {
		return JSON.parse(this.header);
	}
}

export class FormDoTableCell {
	rowspan: number
	colspan: number
}
export class FormDoTableRow {
	cols: FormDoTableCell[]
}
export class FormDoTableHeader {
	rows: FormDoTableRow[]
}