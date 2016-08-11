System.register(['angular2/http'], function(exports_1, context_1) {
    "use strict";
    var __moduleName = context_1 && context_1.id;
    var http_1;
    var ParticipantService;
    return {
        setters:[
            function (http_1_1) {
                http_1 = http_1_1;
            }],
        execute: function() {
            ParticipantService = (function () {
                function ParticipantService(_http) {
                    this._http = _http;
                }
                ParticipantService.prototype.load = function (id) {
                    var url = 'api/v1/participants' + ((id) ? '/' + id : '');
                    return this._http.get(url);
                };
                ParticipantService.prototype.add = function (participant) {
                    var headers = new http_1.Headers();
                    var url = 'api/v1/participants';
                    var body = JSON.stringify(participant);
                    return this._http.post(url, body, headers);
                };
                ParticipantService.prototype.update = function (participant) {
                    var headers = new http_1.Headers();
                    var url = 'api/v1/participants';
                    var body = JSON.stringify(participant);
                    return this._http.post(url, body, headers);
                };
                ParticipantService.prototype.delete = function (id) {
                    var url = 'api/v1/participants/' + id;
                    return this._http.delete(url);
                };
                return ParticipantService;
            }());
            exports_1("ParticipantService", ParticipantService);
        }
    }
});
