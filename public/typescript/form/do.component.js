System.register(['angular2/core', '../participant/info.component', '../form/do-table-header.component', '../types/form', '../service/form.service', 'angular2/router'], function(exports_1, context_1) {
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
    var core_1, info_component_1, do_table_header_component_1, form_1, form_service_1, router_1;
    var FormDoComponent;
    return {
        setters:[
            function (core_1_1) {
                core_1 = core_1_1;
            },
            function (info_component_1_1) {
                info_component_1 = info_component_1_1;
            },
            function (do_table_header_component_1_1) {
                do_table_header_component_1 = do_table_header_component_1_1;
            },
            function (form_1_1) {
                form_1 = form_1_1;
            },
            function (form_service_1_1) {
                form_service_1 = form_service_1_1;
            },
            function (router_1_1) {
                router_1 = router_1_1;
            }],
        execute: function() {
            FormDoComponent = (function () {
                function FormDoComponent(_formService, _rp) {
                    this._formService = _formService;
                    this._rp = _rp;
                }
                FormDoComponent.prototype.ngOnInit = function () {
                    this.loadFormIfNeeded();
                };
                FormDoComponent.prototype.loadFormIfNeeded = function () {
                    var _this = this;
                    if (!!!this.form) {
                        var id = this._rp.params['id'];
                        this._formService.load(id).subscribe(function (data) {
                            _this.form = new form_1.Form(data);
                        }, function (error) {
                            console.log(error);
                        });
                    }
                };
                FormDoComponent = __decorate([
                    core_1.Component({
                        templateUrl: 'template/form/do',
                        providers: [form_service_1.FormService],
                        directives: [info_component_1.ParticipantInfoFormComponent, do_table_header_component_1.FormDoTableHeaderComponent]
                    }), 
                    __metadata('design:paramtypes', [form_service_1.FormService, router_1.RouteParams])
                ], FormDoComponent);
                return FormDoComponent;
            }());
            exports_1("FormDoComponent", FormDoComponent);
        }
    }
});
