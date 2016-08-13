(function(){
	
	var module = angular.module('form-list', [])

	.controller('FormListController', function($scope, formService, ngDialog, RISK_ID, User){
		$scope.forms = [];
		$scope.user = User;
		formService.load(function(forms){
			$scope.forms = forms;
		})
	})

})();