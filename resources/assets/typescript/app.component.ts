import {Component} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES, ROUTER_PROVIDERS} from 'angular2/router';
import {NavigationBar} from './navbar.component';
import {LoginComponent} from './login/login.component';
import {FormListComponent} from './form/list.component';
import {FormDoComponent} from './form/do.component';

@Component({
    selector: 'my-app',
    templateUrl: 'template/shared/home',
    directives: [NavigationBar, ROUTER_DIRECTIVES],
    providers: [ROUTER_PROVIDERS, ROUTER_DIRECTIVES]
})
@RouteConfig([
	{ path: 'home', name: 'Home', component: LoginComponent },
	{ path: 'forms', name: 'Forms', component: FormListComponent },
	{ path: 'form/:id', name: 'Form', component: FormDoComponent },
	{ path: 'auth/login', component: LoginComponent}
])
export class AppComponent {
	
}