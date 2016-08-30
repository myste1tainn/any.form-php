System.register(['angular2/core', 'angular2/http', '../app.config'], function(exports_1, context_1) {
    "use strict";
    var __moduleName = context_1 && context_1.id;
    var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
        var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
        if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
        else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
        return c > 3 && r && Object.defineProperty(target, key, r), r;
    };
    var __metadata = (this && this.__metadata) || function (k, v) {
        if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };
    var core_1, http_1, app_config_1;
    var FormService;
    return {
        setters:[
            function (core_1_1) {
                core_1 = core_1_1;
            },
            function (http_1_1) {
                http_1 = http_1_1;
            },
            function (app_config_1_1) {
                app_config_1 = app_config_1_1;
            }],
        execute: function() {
            FormService = (function () {
                function FormService(_http) {
                    this._http = _http;
                }
                FormService.prototype.headers = function () {
                    var headers = new http_1.Headers();
                    headers.append('Content-Type', 'application/json');
                    return headers;
                };
                FormService.prototype.load = function (id) {
                    if (!!id) {
                        return this._http.get(app_config_1.Config.api('form/' + id));
                    }
                    else {
                        return this._http.get(app_config_1.Config.api('forms'));
                    }
                };
                FormService.prototype.add = function (form) {
                    return this._http.post(app_config_1.Config.api('form'), JSON.stringify(form), this.headers());
                };
                FormService.prototype.update = function (form) {
                    return this._http.put(app_config_1.Config.api('form/' + form.id), JSON.stringify(form), this.headers());
                };
                FormService = __decorate([
                    core_1.Injectable(), 
                    __metadata('design:paramtypes', [http_1.Http])
                ], FormService);
                return FormService;
            }());
            exports_1("FormService", FormService);
        }
    }
});
