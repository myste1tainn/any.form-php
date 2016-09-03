(function(){
	
	var module = angular.module('ammart', [
		// Core
		'ngRoute', 'ngDialog', 'smart-table', 'angular-loading-bar', 'ui.router', 'ngAnimate',
		
		// Components
		'form', 'question', 'criterion', 'choice', 'report', 'ct.ui.router.extras.dsr',
		'definition',

		// Collections
		'Questions', 'Groups'
	])

	.factory('redirectInterceptor', function($q,$location,$window){
	return  {
		'responseError': function(response){
			if (response.status == 302) {
				$window.location.href = response.data;
				return $q.reject(response);
			}else{
				return response;
			}
		}
	}

	})

	.config(function(
		$interpolateProvider, $httpProvider, $stateProvider, $urlRouterProvider,
		$locationProvider, $routeProvider, CSRF_TOKEN, $rootScopeProvider
	){
		$httpProvider.interceptors.push('redirectInterceptor');
		$httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
		$httpProvider.defaults.headers.common['X-Csrf-Token'] = CSRF_TOKEN;
		$locationProvider.html5Mode(true);
		$urlRouterProvider.otherwise('');
	})

	.service('ArrayHelper', function(){

		var _removeBySplice = function(target, items){
			var index = items.indexOf(target);
			if (index > -1) {
				items.splice(index, 1);
				return true;
			} else {
				return false;
			}
		}

		var _searchByID = function(target, items, key){
			if (!!key) {
				if (typeof target == 'object') {
					for (var i = items.length - 1; i >= 0; i--) {
						var item = items[i];
						if (item[key] == target[key]) {
							return item;
						}
					}
				} else {
					for (var i = items.length - 1; i >= 0; i--) {
						var item = items[i];
						if (item[key] == target) {
							return item;
						}
					}
				}
				return null;
			} else {
				for (var i = items.length - 1; i >= 0; i--) {
					var item = items[i];
					if (item.id == target.id) {
						return item;
					}
				}
				return null;
			}
		}

		this.find = _searchByID;
		this.remove = function(target, items) {
			if (!_removeBySplice(target, items)) {
				var item = _searchByID(target, items)
				if (item) {
					console.log(item, 'removed');
					items = _removeBySplice(item, items);
				}
			}
			return items;
		}
	})

	.service('injector', function($state){
		this.parseAndInject = function($scope, propertyName, specificPropertyName) {
			_prop = $state.params[propertyName];
			if (_prop) {
				
			} else {
				if (!!specificPropertyName) {
					_prop = {};
					_prop[specificPropertyName] = $state.params[propertyName+'ID'];
				} else {
					_prop = { id: $state.params[propertyName+'ID'] }
				}
			}
			$scope['_' + propertyName] = _prop;
		}
	})

	.service('sys', function(ngDialog, $rootScope){
		this.dialog = {
			info: function(title, message) {
				ngDialog.open({
					template: message,
					plain: true
				})
			},
			error: function(object){
				ngDialog.open({
					template: (object.message === undefined) ? object : object.message,
					plain: true
				})
			},
			confirm: function(title, message, callback, autoDismiss) {
				if (autoDismiss === undefined) autoDismiss = true;
				ngDialog.open({
					template: 'template/dialog/confirm',
					controllerAs: 'dialog',
					controller: function($scope){
						this.title = title;
						this.message = message;
						this.confirm = function() {
							callback(this, true);
							if (autoDismiss) $scope.closeThisDialog();
						}
						this.decline = function() {
							callback(this, false);
							if (autoDismiss) $scope.closeThisDialog();
						}
					}
				})
			}
		}
	})

	.service('req', function($http, sys){
		this.getData = function(url, callback) {
			$http.get(url)
			.success(function(res, status, headers, config){
				callback(res);
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res);
			});
		}
		this.getMessage = function(url, callback) {
			$http.get(url)
			.success(function(res, status, headers, config){
				callback(res);
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res);
			});
		}

		this.postData = function(url, payload, callback) {
			$http.post(url, payload)
			.success(function(res, status, headers, config){
				callback(res);
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res);
			});
		}
		this.postMessage = function(url, payload, callback) {
			$http.post(url, payload)
			.success(function(res, status, headers, config){
				(res);
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res);
			});
		}
	})

	.service('User', function($http){
		var _this = this;

		this.subscriber = null;
		this.name = null;
		this.level = null;

		this.reload = function(){
			$http.get('api/v1/user')
			.success(function(res, status, headers, config){
				_this.name = res.name;
				_this.level = res.level;	

				if (_this.level === undefined) {
					_this.level = 0;
				}

				if (!!_this.subscriber) {
					_this.subscriber();
				}
			})
			.error(function(res, status, headers, config){
				
			});
		}

		this.subscribe = function(obj) {
			this.subscriber = obj;
		}

		this.reload();
	})

	.directive('navbar', function($http, User){
		return {
			restrict: 'E',
			templateUrl: 'template/navbar',
			controllerAs: 'navbar',
			controller: function($scope, $element, $attrs){
				User.subscribe(function () {
					$scope.user = User;
				})
			}
		}
	})

	.controller('LoginController', function($scope, $http, $state, User){
		$scope.login = function(){
			$http.post('auth/login', {
				username: $scope.username,
				password: $scope.password,
				remember: $scope.remember
			})
			.success(function(res, status, headers, config){
				if (status == 401) {
					$scope.error = res.message;
				} else {
					User.reload();
					$state.go('home');
				}
			})
			.error(function(res, status, headers, config){
				$scope.error = res.error;
			});
		}
	})

	.directive('ngLet', function($http){
		return {
			restrict: 'A',
			controllerAs: 'ngLet',
			controller: function($scope, $element, $attrs){
				components = $attrs.ngLet.split('=');
				for (var i = components.length - 1; i >= 0; i--) {
					components[i] = components[i].trim();
				}
				$scope[components[0]] = $scope.$eval(components[1]);
			}
		}
	})

})();