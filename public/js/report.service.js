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

		this.numberOfPages = function(id, year, numRows, callback){
			$http.get(`api/v1/report/${id}/year/${year}/number-of-rows/${numRows}/number-of-pages`)
			.success(function(res, status, headers, config){
				callback(res);
			})
			.error(function(res, status, headers, config){
				sys.dialog.error('Cannot get number of pages of report '+id);
			});
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

		this.results = function(callback) {
			$http.get('report-results')
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.dialog.error(res);
				}
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res);
			});
		}

		this.person = function(payload, callback) {
			$http.get(`report/by-person/${payload.id}/year/${payload.year}/from/${payload.from}/num/${payload.num}`)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.dialog.error(res)
				}
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res)
			});
		}

		this.school = function(payload, callback) {
			$http.get('report/by-school/'+payload.id+'/year/'+payload.year)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.dialog.error(res);
				}
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res)
			});
		}

		// this.room = function(id, callback) {
		this.room = function(payload, callback) {
			$http.get('report/by-room/'+payload.id+'/class/'+payload.class+'/room/'+payload.room+'/year/'+payload.year)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.dialog.error(res)
				}
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res)
			});
		}

		this.class = function(payload, callback) {
			$http.get('report/by-class/'+payload.id+'/class/'+payload.class+'/year/'+payload.year)
			.success(function(res, status, headers, config){
				if (res.success) {
					callback(res.data);
				} else {
					sys.dialog.error(res)
				}
			})
			.error(function(res, status, headers, config){
				sys.dialog.error(res)
			});
		}
	})

})();