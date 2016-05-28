(function(){
	
	var module = angular.module('report.risk', [])

	.service('$toolbar', function(){
		var _callback = null;
		this.valueChange = function(payload) {
			if (_callback) _callback(payload);
		}

		this.onValueChange = function(callback) {
			_callback = callback;
		}
	})

	.service('$participant', function($http, sys, RISK_ID){
		var successHandlerObject = {
			callback: null,
			handler: function(res, status, headers, config, callback){
				if (res.success) {
					if (res.data !== undefined) {
						successHandlerObject.callback(res.data);
					} else {
						successHandlerObject.callback();
					}
					successHandlerObject.callback = null;
				} else {
					sys.dialog.error(res)
				}
			}
		}
		var errorHandler = function(res, status, headers, config){
			sys.dialog.error(res)
		};

		this.get = function(identifier, callback){
			$http.get('api/v1/participant/'+identifier)
			.success(function(res, status, headers, config){
				callback(res);
			})
			.error(errorHandler);
		}

		this.result = function(id, year, callback){
			$http.get('api/v1/participant/'+id+'/form/'+RISK_ID+'/year/'+year)
			.success(function(res, status, headers, config){
				callback(res);
			})
			.error(errorHandler);
		}
	})

	.controller('ReportPersonRiskToolbarController', function($scope, $class, $toolbar, $state, $time){
		var self = this;
		var currentYear = (new Date()).getFullYear() + 543;
		var pyear = $state.params.year || currentYear;
		this.years = $time.years();
		this.year = $time.yearObjectForYear(pyear);

		this.class = null;
		this.classes = [];
		this.room = null;
		this.rooms = [];

		var changeState = function() {
			var params = {
				class: self.class.value,
				room: self.room.value,
				year: self.year.value
			};
			$state.go('report.risk.overview', params);
		}

		this.classChange = function() {
			// $toolbar.valueChange({id:'class', value:this.class.value});
			changeState();
		}
		this.roomChange = function() {
			// $toolbar.valueChange({id:'room', value:this.room.value});
			changeState();
		}
		this.yearChange = function() {
			// $toolbar.valueChange({id:'year', value:this.year.value});
			changeState();
		}

		$class.all(function(res) {
			for (var i = res.classes.length - 1; i >= 0; i--) {
				var c = res.classes[i];
				self.classes.push({text:c.class, value:c.class});
			};

			for (var i = res.rooms.length - 1; i >= 0; i--) {
				var r = res.rooms[i];
				self.rooms.push({text:r.room, value:r.room});
			};

			// Default select the first row found
			self.class = self.classes[0];
			self.room = self.rooms[0];

			if ($state.params.type != "person") {
				changeState();
			}
		})

		// Emit yearChange once if it is pre-determinded
		// and emit only after all angular is loaded
		if (typeof this.year == 'object') {
			setTimeout(function() {
				self.yearChange();
			}, 500);
		}
	})









































	

	.controller('ReportPersonRiskListController', function($scope, $state, $report, RISK_ID){
		var self = this;

		this.year = $state.params.year;
		this.results = [];
		this.displays = [];

		var prepareDisplaysData = function() {
			for (var i = self.displays.length - 1; i >= 0; i--) {
				var p = self.displays[i];
				p.hasTalent = function() {
					return this.talent != null
				}
				p.hasDisability = function() {
					return this.disabilities.length > 0;
				}
			}
		}

		this.select = function(participant) {
			$state.go('^.detail', {
				participantID: participant.identifier,
				participant: participant,
				year: this.year
			})
		}

		var payload = { id: RISK_ID, year: this.year };
		$report.person(payload, function(participants){
			self.results = self.displays = participants;
			prepareDisplaysData();
		})
	})
























































	.controller('ReportRiskPersonDetailController', function($scope, $state, $participant){
		var self = this;

		this.selectedAspect = $state.params.aspect || null;
		this.year = $state.params.year || null;
		$scope.participant = {};

		if ($state.params.participant) {
			$scope.participant = $state.params.participant;
		} else {
			$participant.get($state.params.participantID, function(res){
				if (res.success) {
					var participant = res.data;
					$scope.participant.id 			= participant.id;
					$scope.participant.identifier 	= participant.identifier;
					$scope.participant.firstname 	= participant.firstname;
					$scope.participant.lastname 	= participant.lastname;
					$scope.participant.class 		= participant.class;
					$scope.participant.room 		= participant.room;
					$scope.participant.number 		= participant.number;

					// Get the result of the participant
					$participant.result(participant.id, self.year, function(res){
						if (res.success) {
							$scope.participant.risks = res.data.aspects;
							$scope.participant.talent = res.data.talent;
							$scope.participant.disabilities = res.data.disabilities;
						} else {
							$scope.errorMessage = res.message;
							$scope.participant = null;		
						}
					})
				} else {
					$scope.errorMessage = res.message;
					$scope.participant = null;
				}
			})
		}

		this.selectAspect = function(aspect) {
			this.selectedAspect = aspect;

			var params = { aspectName: null, aspect: aspect };
			switch (aspect) {
				case $scope.participant.risks.study: params.aspectName = 'study'; break;
				case $scope.participant.risks.health: params.aspectName = 'health'; break;
				case $scope.participant.risks.aggressiveness: params.aspectName = 'aggressiveness'; break;
				case $scope.participant.risks.economy: params.aspectName = 'economy'; break;
				case $scope.participant.risks.security: params.aspectName = 'security'; break;
				case $scope.participant.risks.drugs: params.aspectName = 'drugs'; break;
				case $scope.participant.risks.sexuality: params.aspectName = 'sexuality'; break;
				case $scope.participant.risks.games: params.aspectName = 'games'; break;
				case $scope.participant.risks.electronics: params.aspectName = 'electronics'; break;
				default: break;
			}
		}

		this.isSelected = function(aspect) {
			return this.selectedAspect == aspect;
		}
	})




































	.controller('ReportRiskOverviewController', function($scope, $toolbar, $state, $report, RISK_ID){
		var self = this;
		var _class = $state.params.class || null;
		var _room = $state.params.room || null;
		var _year = $state.params.year || null;
		var _type = $state.params.type || null;

		this.aspects = [];

		var _payload = null;
		var _reportLoader = null;
		var _callback = function(report){
			self.aspects = report;
		};

		var _reloadData = function() {
			if (_type == 'room') {
				_payload = { id: RISK_ID, class: _class, room: _room, year: _year };
				_reportLoader = $report.room;
			} else if (_type == 'class') {
				_payload = { id: RISK_ID, class: _class, year: _year };
				_reportLoader = $report.class;
			} else if (_type == 'school') {
				_payload = { id: RISK_ID, year: _year };
				_reportLoader = $report.school;
			}

			_reportLoader(_payload, _callback);
		}

		// Reload data if both argument is ready for type room
		if (_type == 'room') {
			if (_class != null && _room != null && _year != null) {
				_reloadData();
			}
		} else if (_type == 'class') {
			if (_class != null && _year != null) {
				_reloadData();
			}
		} else {
			// Reload immediately
			_reloadData();
		}
	})


})();