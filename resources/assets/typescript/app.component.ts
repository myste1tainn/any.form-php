import {Component} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES, ROUTER_PROVIDERS} from 'angular2/router';
import {NavigationBar} from './navbar.component';
import {LoginComponent} from './login/login.component';

@Component({
    selector: 'my-app',
    templateUrl: 'template/shared/home',
    directives: [NavigationBar, ROUTER_DIRECTIVES],
    providers: [ROUTER_PROVIDERS, ROUTER_DIRECTIVES]
})
@RouteConfig([
	{ path: '/home', component: LoginComponent },
	{ path: '/auth/login', component: LoginComponent}
])
export class AppComponent {
	
}