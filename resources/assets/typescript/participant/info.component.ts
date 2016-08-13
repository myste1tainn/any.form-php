import {Component, OnInit}		from 'angular2/core';
import {ParticipantService}		from '../service/participant.service';
import {Participant}			from '../types/participant';
import {ROUTER_PROVIDERS, ROUTER_DIRECTIVES, RouteConfig} from 'angular2/router';

@Component({
	selector: 'participant-info-form',
	templateUrl: 'template/participant/info-form',
	providers: [ParticipantService],
	directives: [ROUTER_DIRECTIVES]
})
export class ParticipantInfoFormComponent implements OnInit {
	participants: Array<Participant>;
	constructor(private _service:ParticipantService) {}

	ngOnInit() {
		
	}
}