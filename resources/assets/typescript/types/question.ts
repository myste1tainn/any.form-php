import {Form} from './form'
import {Group} from './group'

export class Question {
	id: number
	order: number
	label: string
	name: string
	description: string
	type: number
	questionaireID: number
	questionaire: Form
	groupID: number
	group: Group
}