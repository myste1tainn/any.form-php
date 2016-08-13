(function(){
	
	var module = angular.module('form-create-header-toggler', [])

	.directive('headerToggler', function($http, formService){
		return {
			restrict: 'A',
			require: 'formCreate',
			controllerAs: 'headerToggler',
			controller: function($scope, $element, $attrs){
				var _hasHeader = false;

				$scope.toggleHasHeader = function(val, relectToElement) {
					_hasHeader = val;

					if (_hasHeader) {
						if ($scope.form.header) {

						} else {
							$scope.form.header = formService.newHeader();
						}
					};

					if (relectToElement) {
						$element.prop('checked', val);
					}
				}

				$scope.hasHeader = function() {
					return _hasHeader;
				}

				$scope.addHeaderRow = function() {
					var row = formService.newHeaderRow();
					$scope.form.header.rows.push(row);
				}

				$scope.addHeaderCol = function(row) {
					var col = formService.newHeaderCol()
					row.cols.push(col);
				}

				$element.change(function (e) {
					$scope.toggleHasHeader($element.prop('checked'));
					$scope.$apply();
				})
			}
		}
	})

})();	