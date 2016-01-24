(function(){
	
	var module = angular.module('room', [])

	.directive('roomReport', function($report, $class){
		return {
			restrict: 'E',
			require: '^report',
			link: function ($scope, $element, $attrs, $controller) {
				console.log($controller);
				console.log($scope);
				$controller.roomReport = $scope;
			},
			controllerAs: 'roomReport',
			templateUrl: 'report/template/room',
			controller: function($scope, $element, $attrs){
				var _ = this;

				$scope.classes = [];
				$scope.rooms = [];

				$scope.classChange = function() {
					$scope.getData();
				}

				$scope.roomChange = function() {
					$scope.getData();
				}

				$scope.results = [];
				$scope.displayedResults = [];

				var createDisplayedResult = function() {
					$scope.displayedResults = [].concat($scope.results);
				}

				$scope.getData = function(clazz, room) {
					var cb = $report.room;
					var clazz = $scope.class.value;
					var room = $scope.room.value;
					cb($scope.activeForm.id, clazz, room, function(result){
						$scope.results = result;
						console.log(result);
					})
				}

				$class.all(function(res) {
					for (var i = res.classes.length - 1; i >= 0; i--) {
						var c = res.classes[i];
						$scope.classes.push({text:c.class, value:c.class});
					};

					for (var i = res.rooms.length - 1; i >= 0; i--) {
						var r = res.rooms[i];
						$scope.rooms.push({text:r.room, value:r.room});
					};

					$scope.class = $scope.classes[0];
					$scope.room = $scope.rooms[0];
					
					if ($scope.activeForm) {
						$scope.getData();
					}
				})
			}
		}
	})

})();