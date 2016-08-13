///<reference path="../../../node_modules/angular2/typings/browser.d.ts"/>

import {bootstrap}    			from 'angular2/platform/browser';
import {HTTP_PROVIDERS}			from 'angular2/Http';
import {AppComponent} 			from './app.component';
import {APP_ROUTER_PROVIDERS} 	from './app.routes';

bootstrap(AppComponent, [APP_ROUTER_PROVIDERS, HTTP_PROVIDERS])
.catch(err => console.error(err));