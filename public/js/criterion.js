(function(){
	
	var module = angular.module('criterion', [])

	.service('$criterion', function(){
		this.newInstance = function() {
			return {
				id: -1,
				label: "ดี, พอใช้, ปรับปรุง",
				from: 0,
				to: 0
			}
		}
	})

})();