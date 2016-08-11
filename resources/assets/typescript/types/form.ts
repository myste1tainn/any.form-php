import {Question} from './question'

export class TableHeaderColumn {
	colspan: number
	rowspan: number
	label: string
}
export class TableHeaderRow {
	cols: TableHeaderColumn[]
}
export class TableHeader {
	rows: TableHeaderRow[]
}

export class Form {
	id: number
	parentID: number
	name: string
	header: string
  	headerObject: TableHeader
  	level: number
  	questions: Question[]

  	constructor(response:any) {
  		this.id = response.id;
 		this.parentID = response.parentID;
 		this.name = response.name;
 		this.header = response.header;
 		this.level = response.level;
  	}
}