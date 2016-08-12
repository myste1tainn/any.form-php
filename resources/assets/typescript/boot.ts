///<reference path="../../../node_modules/angular2/typings/browser.d.ts"/>

import {bootstrap}    			from 'angular2/platform/browser'
import {AppComponent} 			from './app.component'
import {APP_ROUTER_PROVIDERS} 	from './app.routes';

bootstrap(AppComponent, [APP_ROUTER_PROVIDERS])
.catch(err => console.error(err));