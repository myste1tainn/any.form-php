(function(){
	
 	var module = angular.module('form', [
 		'form-list', 'form-do', 'form-create',
 		'form-service', 'risk-screening']
 	)

	.service('$input', function() {
		this.newInstance = function() {
			return {
				id: -1,
				name: "New Input",
				placeholder: "New Input Placeholder",
				type: 0,
			}
		}
	})

	.service('$answer', function($http, req, sys) {
		this.load = function(formID, academicYear, participantID, callback) {
			var url = 'api/answers/'+formID+'/'+academicYear+'/'+participantID;
			req.getData(url, callback);
		}
	})

	.service('$participant', function($http, req) {
		this.load = function(id, callback) {
			req.getData('api/participant/'+id, callback);
		}
	})

	.directive('participantInfo', function($http, ngDialog){
		return {
			restrict: 'EA',
			controllerAs: 'participantInfo',
			controller: function($scope, $element, $attrs){
				$scope.participant = { 
					identifier: null, 
					choices: []
				};

				$scope.validateFormInput = function() {
					var valid = (
								$scope.participant.identifier != null && 
								$scope.participant.identifier != ""
								);

					if (!valid) {
						ngDialog.open({
							plain: true,
							template: 'กรุณาใส่หมายเลขประจำตัวนักเรียน'
						});
					}

					return valid;
				}

				$scope.mockupInput = function() {
					$scope.participant.identifier = 22611;
					$scope.participant.firstname = "อานนท์";
					$scope.participant.lastname = "คีรีนะ";
					$scope.participant.class = 6;
					$scope.participant.room = 4;
					$scope.participant.number = 26;
				}

				// $scope.mockupInput();
			}
		}
	})

})();