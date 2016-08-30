(function(){
	
	var module = angular.module('identifier.component', ['identifier.service'])

	.controller('IdentifierListController', function($scope, identifierSerivce){
		$scope.identifiers = [];

		identifierSerivce.load(function(results, error){
			if (error) {

			} else {
				$scope.identifiers = results;
			}
		})
	})

	.controller('IdentifierCellController', function($scope, $attr, identifierSerivce){
		$scope.identifier = $scope.$eval($attr.identifier);

		$scope.addRelatedIDs = function(id) {
			$scope.identifier.relatedIDs += id+',';
		}
		$scope.getRelatedIDs = function() {
			return $scope.identifier.relatedIDs.split(',');
		}
		$scope.save = function() {	
			identifierSerivce.add(function(results, error){
				if (error) {

				} else {

				}
			})
		}
	})

})();