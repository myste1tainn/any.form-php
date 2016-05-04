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
		this.year = $state.params.year;
	})

	.controller('ReportPersonRiskListController', function($scope, $state){
		this.year = $state.params.year;
		this.results = [];
		this.displays = [
			{
				identifier: '00001', firstname: 'Myra', lastname: 'Caldwell',
				class: 4, room: 12, number: 6,
				talent: null, disabilities: []
			},
			{
				identifier: '00002', firstname: 'Corey', lastname: 'Graves',
				class: 5, room: 7, number: 17,
				talent: null, disabilities: []
			},
			{
				identifier: '00003', firstname: 'Morris', lastname: 'Houston',
				class: 4, room: 12, number: 25,
				talent: null, disabilities: []
			},
			{
				identifier: '00004', firstname: 'Kenneth', lastname: 'Frank',
				class: 4, room: 4, number: 3,
				talent: null, disabilities: []
			},
			{
				identifier: '00005', firstname: 'Lori', lastname: 'Ballard',
				class: 5, room: 2, number: 24,
				talent: null, disabilities: []
			},
			{
				identifier: '00006', firstname: 'Bernard', lastname: 'Osborne',
				class: 5, room: 2, number: 3,
				talent: null, disabilities: []
			},
			{
				identifier: '00007', firstname: 'Roman', lastname: 'Sutton',
				class: 3, room: 7, number: 5,
				talent: null, disabilities: []
			},
			{
				identifier: '00008', firstname: 'Alma', lastname: 'Gibbs',
				class: 2, room: 3, number: 25,
				talent: null, disabilities: []
			},
			{
				identifier: '00009', firstname: 'Mercedes', lastname: 'Lane',
				class: 2, room: 8, number: 14,
				talent: null, disabilities: []
			},
			{
				identifier: '00010', firstname: 'Chad', lastname: 'Beck',
				class: 4, room: 4, number: 22,
				talent: null, disabilities: []
			},
			{
				identifier: '00011', firstname: 'Jessie', lastname: 'Jones',
				class: 3, room: 8, number: 21,
				talent: null, disabilities: []
			},
			{
				identifier: '00012', firstname: 'Arnold', lastname: 'Moore',
				class: 2, room: 11, number: 12,
				talent: null, disabilities: []
			},
			{
				identifier: '00013', firstname: 'Aubrey', lastname: 'Jefferson',
				class: 1, room: 9, number: 3,
				talent: null, disabilities: []
			},
			{
				identifier: '00014', firstname: 'Rolando', lastname: 'Ramsey',
				class: 3, room: 7, number: 36,
				talent: null, disabilities: []
			},
			{
				identifier: '00015', firstname: 'Blanche', lastname: 'Thomas',
				class: 3, room: 4, number: 4,
				talent: null, disabilities: []
			},
			{
				identifier: '00016', firstname: 'Darnell', lastname: 'Hampton',
				class: 3, room: 10, number: 22,
				talent: null, disabilities: []
			},
			{
				identifier: '00017', firstname: 'Vickie', lastname: 'Francis',
				class: 3, room: 12, number: 9,
				talent: null, disabilities: []
			},
			{
				identifier: '00018', firstname: 'Juan', lastname: 'Reed',
				class: 5, room: 11, number: 9,
				talent: null, disabilities: []
			},
			{
				identifier: '00019', firstname: 'Sonja', lastname: 'Carlson',
				class: 5, room: 4, number: 31,
				talent: null, disabilities: []
			},
			{
				identifier: '00020', firstname: 'Elizabeth', lastname: 'Clayton',
				class: 2, room: 1, number: 8,
				talent: null, disabilities: []
			},
		];

		for (var i = this.displays.length - 1; i >= 0; i--) {
			var p = this.displays[i];
			p.countRisk = function(type) {
				var count = 0;
				if (type == 'normal') {
					for (var j = this.risks.length - 1; j >= 0; j--) {
						count += this.risks[j].normal.length
					}
				} else if (type == 'normal') {
					for (var j = this.risks.length - 1; j >= 0; j--) {
						count += this.risks[j].high.length
					}
				} else if (type == 'normal') {
					for (var j = this.risks.length - 1; j >= 0; j--) {
						count += this.risks[j].veryHigh.length
					}
				}
				return count;
			}
			p.hasTalent = function() {
				return this.talent != null
			}
			p.hasDisability = function() {
				return this.disabilities.length > 0;
			}
		}

		this.select = function(participant) {
			$state.go('^.detail', {
				participantID: participant.identifier,
				participant: participant,
				year: this.year
			})
		}
	})
























































	.controller('ReportRiskPersonDetailController', function($scope, $state, $participant){
		var self = this;

		this.selectedAspect = $state.params.aspect || null;
		this.year = $state.params.year || null;
		$scope.participant = {};

		if ($state.params.participant) {
			$scope.participant.identifier = $state.params.participant.identifier;
			$scope.participant.firstname = $state.params.participant.firstname;
			$scope.participant.lastname = $state.params.participant.lastname;
			$scope.participant.class = $state.params.participant.class;
			$scope.participant.room = $state.params.participant.room;
			$scope.participant.number = $state.params.participant.number;
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
							$scope.participant.risks = res.data.answers;
							console.log($scope.participant);
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