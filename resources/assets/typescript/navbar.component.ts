import {Component} from 'angular2/core';
import {RouterLink} from 'angular2/router';
@Component({
	selector: 'navbar',
	templateUrl: 'template/navbar',
	bindings: [RouterLink],
	directives: [RouterLink]
})
export class NavigationBar {}