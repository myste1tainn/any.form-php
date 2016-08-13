(function(){
	
	var module = angular.module('form-service', [])

	.service('formService', function(
		$http, $question, $criterion, ngDialog, req, sys,
		SDQ_ID, SDQT_ID, SDQP_ID, EQ_ID, RISK_ID) {
		var _this = this;

		this.newInstance = function() {
			return {
				id: -1,
				name: "แบบฟอร์มใหม่",
				criteria: [$criterion.newInstance()],
				questions: [$question.newInstance()],
				type: 0,
				level: 0
			}
		}

		this.newHeader = function() {
			return {
				rows: [this.newHeaderRow()]
			}
		}

		this.newHeaderRow = function () {
			return {
				cols: [this.newHeaderCol()]
			}
		}

		this.newHeaderCol = function () {
			return {
				rowspan: 1, colspan: 1, label: 'New Label'
			}
		}

		this.load = function(id, callback) {
			if (typeof id == 'function' && !!!callback) {
				callback = id;
				$http.get('api/v1/forms')
				.success(function(res, status, headers, config){
					for (var i = res.length - 1; i >= 0; i--) {
						_this.injectFunctions(res[i]);
					}

					callback(res);
				})
				.error(function(res, status, headers, config){
					callback(this.newInstance());
				});
			} else {
				$http.get('api/v1/form/'+id)
				.success(function(res, status, headers, config){
					callback(res);
				})
				.error(function(res, status, headers, config){
					callback(this.newInstance());
				});
			}
		}

		this.injectFunctions = function(form){
			form.isSDQForm = function(){ 
				return this.id == SDQ_ID || this.id == SDQP_ID || this.id == SDQT_ID;
			}
			form.isEQForm = function(){ 
				return this.id == EQ_ID;
			}
			form.isRiskScreeningForm = function(){ 
				return this.id == RISK_ID;
			}
			form.isGeneralForm = function(){ 
				return !(this.isSDQForm() || this.isRiskScreeningForm())
			}
			form.injectedFunctions = true;
		}

		this.save = function(Form, callback) {
			req.postData('api/v1/form', Form, callback);
		}

		this.submit = function(result, callback) {
			req.postMessage('api/v1/form/submit', result, callback);
		}
	})

})();