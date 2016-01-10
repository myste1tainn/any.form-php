(function(){
	
	var module = angular.module('question', [])

	.service('$question', function($choice){
		this.newInstance = function() {
			return {
				id: -1,
				order: 1,
				label: "1.",
				name: "คำถามใหม่",
				description: "",
				choices: [$choice.newInstance()],
				type: 0,
				folded: true,
			}
		}
	})

})();