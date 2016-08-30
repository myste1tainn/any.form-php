(function(){
	
	var module = angular.module('report.service', [])

	.service('reportService', function($http, sys){
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

		var _errorHandler = function(res, status, headers, config){
			if (res.message) {
				sys.dialog.error("Error: " + status + " \n<br />" + res.message);
			} else {
				sys.dialog.error("Error: " + status + " \n<br />" + res);
			}
		};
		var _success = {
			callback: null,
			handler: function(res, status, headers, config){
				if (status > 299) {
					_errorHandler(res, status, headers, config);
				} else {
					_success.callback(res);
				}
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

		this.numberOfPages = function(id, year, numRows, callback){
			_success.callback = callback;
			$http.get(`api/v1/report/${id}/year/${year}/number-of-rows/${numRows}/number-of-pages`)
			.success(_success.handler)
			.error(_errorHandler);
		}

		this.results = function(callback) {
			_success.callback = callback;
			$http.get('report-results')
			.success(_success.handler)
			.error(_errorHandler);
		}

		this.person = function(payload, callback) {
			$http.get(`api/v1/report/by-person/${payload.id}/year/${payload.year}/from/${payload.from}/num/${payload.num}`)
			.success(callback)
			.error(_errorHandler);
		}

		this.school = function(payload, callback) {
			$http.get('api/v1/report/by-school/'+payload.id+'/year/'+payload.year)
			.success(callback)
			.error(_errorHandler);
		}

		// this.room = function(id, callback) {
		this.room = function(payload, callback) {
			_success.callback = callback;
			$http.get('api/v1/report/by-room/'+payload.id+'/class/'+payload.class+'/room/'+payload.room+'/year/'+payload.year)
			.success(_success.handler)
			.error(_errorHandler);
		}

		this.class = function(payload, callback) {
			_success.callback = callback;
			$http.get('api/v1/report/by-class/'+payload.id+'/class/'+payload.class+'/year/'+payload.year)
			.success(_success.handler)
			.error(_errorHandler);
		}

		this.participantResult = function(id, formID, year, callback){
			_success.callback = callback;
			$http.get('api/v1/participant/'+id+'/form/'+formID+'/year/'+year)
			.success(_success.handler)
			.error(_errorHandler);
		}
	})

})();