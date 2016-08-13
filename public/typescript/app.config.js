System.register([], function(exports_1, context_1) {
    "use strict";
    var __moduleName = context_1 && context_1.id;
    var AppConfig, Config;
    return {
        setters:[],
        execute: function() {
            AppConfig = (function () {
                function AppConfig() {
                    this._apiEndpoint = 'api/v1/';
                    this._templateEndpoint = 'template/';
                }
                AppConfig.prototype.api = function (uri) {
                    return this._apiEndpoint + uri;
                };
                AppConfig.prototype.template = function (uri) {
                    return this._templateEndpoint + uri;
                };
                return AppConfig;
            }());
            exports_1("Config", Config = new AppConfig());
        }
    }
});
