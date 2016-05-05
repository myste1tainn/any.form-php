(function(){
	
	var module = angular.module('report.risk', [])

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

	.controller('ReportPersonRiskToolbarController', function($scope, $state){
		var currentYear = (new Date()).getFullYear() + 543;
		this.year = $state.params.year || currentYear;
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
					return self.talent != null
				}
				p.hasDisability = function() {
					return self.disabilities.length > 0;
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
			console.log(participants);
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
							$scope.participant.risks = res.data.risks;
							$scope.participant.talent = res.data.talent;
							$scope.participant.disabilities = res.data.disabilities;
							console.log(res.data);
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

})();