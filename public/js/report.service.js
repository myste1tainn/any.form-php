(function(){
	
	var module = angular.module('report.service', [])

	.service('reportService', function($http, $q, sys){

		this.reportTypes = [{
			name: 'รายบุคคล',
			value: 'person'
		}, {
			name: 'รายห้องเรียน',
			value: 'room'
		}, {
			name: 'รายชั้นปี',
			value: 'class'
		}, {
			name: 'ภาพรวมทั้งโรงเรียน',
			value: 'school'
		}];

		var _errorHandler = function(d) {
			return function(res, status, headers, config){
				var msg = res.message;
				if (!msg) {msg = res;}
				sys.dialog.error("Error: " + status + " \n<br />" + msg);
				d.reject(res, status, headers, config)
			}
		};
		var _successHandler = function(d) {
			return function(res, status, headers, config){
				(status > 299) ? 
				_errorHandler(res, status, headers, config) : 
				d.resolve(res, status, headers, config);
			}
		}
		this.functionForType = function(type) {
			if (typeof type == 'object') {
				type = type.value;
			}
			
			if (type === 'person') { return this.person; }
			else if (type === 'room') { return this.room; }
			else if (type === 'class') { return this.class; }
			else if (type === 'school') { return this.school; }
		}
		__get = function(url) {
			var d = $q.defer();
			$http.get(url).success(_successHandler(d)).error(_errorHandler(d));
			return d.promise;
		}
		__reportURL = function(url, by) {
			if (!!by) {
				return `api/v1/report/${by}/${url}`;
			} else {
				return `api/v1/report/${url}`;
			}
		}
		this.numberOfPages = function(id, year, numRows){
			var url = __reportURL(`${id}/year/${year}/number-of-rows/${numRows}/number-of-pages`)
			return __get(url);
		}
		this.results = function(callback) {
			return __get('report-results');
		}
		this.person = function(payload) {
			var url = __reportURL(`${payload.id}/year/${payload.year}/from/${payload.from}/num/${payload.num}`, 'by-person')
			return __get(url);
		}
		this.school = function(payload) {
			var url = __reportURL(`${payload.id}/year/${payload.year}`, 'by-school')
			return __get(url);
		}
		this.room = function(payload) {
			var url = __reportURL(`${payload.id}/class/${payload.class}/room/${payload.room}/year/${payload.year}`, 'by-room')
			return __get(url);
		}
		this.class = function(payload) {
			var url = __reportURL(`${payload.id}/class/${payload.class}/year/${payload.year}`, 'by-class');
			return __get(url);
		}

		this.participantResult = function(id, formID, year){
			var d = $q.defer();
			$http.get('api/v1/participant/'+id+'/form/'+formID+'/year/'+year)
			.success(_successHandler(d))
			.error(_errorHandler(d));
			return d.promise;
		}

		this.countGroup = function(payload){
			var d = $q.defer();
			var classParameter = (payload.class) ? `/class/${payload.class}/` : '';
			var roomParameter = (payload.room) ? `/room/${payload.room}` : '';
			$http.get(`api/v1/report/${payload.reportID}/count-group/${payload.groupName}/year/${payload.year}${classParameter}${roomParameter}`)
			.success(_successHandler(d))
			.error(_errorHandler(d));
			return d.promise;
		}

		this.injectFunctions = function(target){
			target.hasTalent = function() {
				return !!this.talent;
			}

			__propertyWithPath = function(components, target){
				var property = null;
				var propertyName = components.shift()
				for (var i = target.properties.length - 1; i >= 0; i--) {
					var p = target.properties[i]
					if (p.name == propertyName) {
						property = p;
						if (components.length > 0) {
							return __propertyWithPath(components, property);
						}
						break;
					}
				}
				return property
			}
			__propertyWithName = function(name) {
				var components = name.split('.');
				var property = __propertyWithPath(components, this);
				return property;
			}

			target.propertyWithName = __propertyWithName;

			target.levelOf = function(name) {
				var property = this.propertyWithName(name);
				if (!!property) {
					if (property.valueString == 'ต่ำกว่าปกติ') {
						return 0;
					} else if (property.valueString == 'ปกติ') {	
						return 1;
					} else if (property.valueString == 'สูงกว่าปกติ') {
						return 2;
					}
				} else {
					return -1;
				}
			}
			target.stringOf = function(name) {
				var property = this.propertyWithName(name);
				for (var i = this.properties.length - 1; i >= 0; i--) {
					if (this.properties[i].name == name) {
						property = this.properties[i];
						break;
					}
				}
				if (!!property) {
					return property.valueString;
				} else {
					return -1;
				}
			}

			var __createGraphObjectOnPropertyName = function(name) {
				var property = this.propertyWithName(name);
				if (!!property) {
					var graphObject = {
						min: property.minValue,
						max: property.maxValue,
						value: property.value,
						data: [],
						isInRange: function(val){
							return val >= this.min-1 && val < this.max-1;
						},
						isValue: function(val) {
							return this.value == val;
						}
					};
					for (var i = 0; i < 28; i++) {
						o = {};
						graphObject.data.push(o);
					}
					property.graphObject = graphObject;
				}
			}

			var __injectIfNeeded = function(target, fn) {
				if (target.properties) {
					for (var i = target.properties.length - 1; i >= 0; i--) {
						target.properties[i].propertyWithName = __propertyWithName
						target.properties[i].createGraphObject = fn;
						__injectIfNeeded(target.properties[i], fn);
					}
				}
			}

			target.createGraphObject = __createGraphObjectOnPropertyName;
			__injectIfNeeded(target, __createGraphObjectOnPropertyName);


			if (target.properties) {
				for (var i = target.properties.length - 1; i >= 0; i--) {
					var p = target.properties[i];
					target.createGraphObject(p.name);
					for (var j = p.properties.length - 1; j >= 0; j--) {
						var pp = p.properties[j]
						p.createGraphObject(pp.name);
					}
				}
			}
			
			target.graphOf = function(name){
				return this.propertyWithName(name).graphObject;
			}
		}
	})

})();