(function(){
	
	var module = angular.module('report.sdq', [])

	.controller('SDQReportController', function(
		$scope, $state, $time, $class, SDQ_ID){

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
			$state.go('report.sdq.list', params);
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
		// if (typeof this.year == 'object') {
		// 	setTimeout(function() {
		// 		self.yearChange();
		// 	}, 500);
		// }
	})
























	.controller('SDQReportListController', function($scope, $state, $report, SDQ_ID){
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

		var payload = { id: SDQ_ID, year: this.year };
		$report.person(payload, function(participants){
			self.results = self.displays = participants;
			prepareDisplaysData();
		})
	})























	.controller('SDQReportDetailController', function($scope, $state, $participant, SDQ_ID){
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
					$scope.participant = participant

					// Get the result of the participant
					$participant.result(participant.id, SDQ_ID, self.year, function(res){
						if (res.success) {
							$scope.participant.groups = res.data.groups;
							$scope.participant.chronic = res.data.chronic;
							$scope.participant.notease = res.data.notease;
							$scope.participant.lifeProblems = res.data.lifeProblems;
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

		this.isSelected = function(aspect) {
			return this.selectedAspect == aspect;
		}
	})



























	.controller('SDQReportOverviewController', function($scope, SDQ_ID){
		//Code
	})


})();