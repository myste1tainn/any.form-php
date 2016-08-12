import {Component} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES, ROUTER_PROVIDERS} from 'angular2/router';
import {NavigationBar} from './navbar.component';
import {LoginComponent} from './login/login.component';
import {FormDoComponent} from './form/do.component';
import {FormListComponent} from './form/list.component';

@Component({
    selector: 'my-app',
    templateUrl: 'template/home',
    directives: [NavigationBar, ROUTER_DIRECTIVES],
    providers: [ROUTER_PROVIDERS, ROUTER_DIRECTIVES]
})
@RouteConfig([
	{ path: '/auth/login', name: 'Login', component: LoginComponent },
	{ path: '/forms', name: 'FormList', component: FormListComponent },
	{ path: '/form/:id', name: 'FormDo', component: FormDoComponent },
])
export class AppComponent {}