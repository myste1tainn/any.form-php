(function(){
	
	var module = angular.module('report.risk', [])

	.service('$toolbar', function(){
		var _callback = null;
		this.valueChange = function(payload) {
			if (_callback) _callback(payload);
		}

		this.onValueChange = function(callback) {
			_callback = callback;
		}
	})

	.service('$participant', function($http, sys){
		var successHandlerObject = {
			callback: null,
			handler: function(res, status, headers, config, callback){
				if (res.success) {
					if (res.data !== undefined) {
						successHandlerObject.callback(res.data);
					} else {
						successHandlerObject.callback();
					}
					successHandlerObject.callback = null;
				} else {
					sys.dialog.error(res)
				}
			}
		}
		var errorHandler = function(res, status, headers, config){
			sys.dialog.error(res)
		};

		this.get = function(identifier, callback){
			$http.get('api/v1/participant/'+identifier)
			.success(function(res, status, headers, config){
				callback(res);
			})
			.error(errorHandler);
		}

		this.result = function(id, formID, year, callback){
			$http.get('api/v1/participant/'+id+'/form/'+formID+'/year/'+year)
			.success(function(res, status, headers, config){
				callback(res);
			})
			.error(errorHandler);
		}
	})

})();