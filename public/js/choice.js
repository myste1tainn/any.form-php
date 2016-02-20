(function(){
	
	var module = angular.module('choice', [])

	.service('$choice', function(){
		this.newInstance = function(question, choice) {
			return {
				id: -1,
				label: "ก.",
				name: "ถูกทุกข้อ",
				description: "",
				note: "",
				type: 0,
				enabled: true,
				value: 0,
			}
		}
	})

})();