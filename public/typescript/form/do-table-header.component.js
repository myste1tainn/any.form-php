System.register(['angular2/core', '../types/form'], function(exports_1, context_1) {
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
    var core_1, form_1;
    var FormDoTableHeaderComponent;
    return {
        setters:[
            function (core_1_1) {
                core_1 = core_1_1;
            },
            function (form_1_1) {
                form_1 = form_1_1;
            }],
        execute: function() {
            FormDoTableHeaderComponent = (function () {
                function FormDoTableHeaderComponent() {
                }
                FormDoTableHeaderComponent.prototype.ngOnInit = function () {
                    console.log('after');
                    for (var i = this.header.rows.length - 1; i >= 0; i--) {
                        console.log(this.header.rows[i]);
                    }
                };
                __decorate([
                    core_1.Input(), 
                    __metadata('design:type', form_1.FormDoTableHeader)
                ], FormDoTableHeaderComponent.prototype, "header", void 0);
                FormDoTableHeaderComponent = __decorate([
                    core_1.Component({
                        selector: '[form-do-table-header]',
                        templateUrl: 'template/form/do-table-header',
                    }), 
                    __metadata('design:paramtypes', [])
                ], FormDoTableHeaderComponent);
                return FormDoTableHeaderComponent;
            }());
            exports_1("FormDoTableHeaderComponent", FormDoTableHeaderComponent);
        }
    }
});
