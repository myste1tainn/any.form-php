(function(){
	
	var module = angular.module('class', [])

	.service('$class', function($http, sys){
		var _classes = null;

		this.all = function(callback) {
			if (_classes) {
				callback(_classes);
			} else {
				$http.get('class/all')
				.success(function(res, status, headers, config){
					if (res.success) {
						_classes = res.data;
						callback(res.data);
					} else {
						sys.error(res);
					}
				})
				.error(function(res, status, headers, config){
					sys.error(res);
				});
			}
		}
	})

})();