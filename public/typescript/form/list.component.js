System.register(['angular2/core', '../service/form.service', '../service/data.service', 'angular2/router'], function(exports_1, context_1) {
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
    var core_1, form_service_1, data_service_1, router_1;
    var FormListComponent;
    return {
        setters:[
            function (core_1_1) {
                core_1 = core_1_1;
            },
            function (form_service_1_1) {
                form_service_1 = form_service_1_1;
            },
            function (data_service_1_1) {
                data_service_1 = data_service_1_1;
            },
            function (router_1_1) {
                router_1 = router_1_1;
            }],
        execute: function() {
            FormListComponent = (function () {
                function FormListComponent(_formService, _dataService, _router) {
                    var _this = this;
                    this._formService = _formService;
                    this._dataService = _dataService;
                    this._router = _router;
                    this._formService.load()
                        .subscribe(function (loadedForms) {
                        _this.formList = loadedForms;
                    });
                }
                FormListComponent = __decorate([
                    core_1.Component({
                        templateUrl: 'template/form/list',
                        bindings: [form_service_1.FormService, router_1.Router, data_service_1.DataService],
                        directives: [router_1.ROUTER_DIRECTIVES]
                    }), 
                    __metadata('design:paramtypes', [form_service_1.FormService, data_service_1.DataService, router_1.Router])
                ], FormListComponent);
                return FormListComponent;
            }());
            exports_1("FormListComponent", FormListComponent);
        }
    }
});
