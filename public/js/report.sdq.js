(function(){
	
	var module = angular.module('report.sdq', [])

	.controller('SDQReportToolbarController', function(
		$scope, $state, $time, $class, $report, $controller){

		var self = $scope;
		var currentYear = (new Date()).getFullYear() + 543;
		var pyear = $state.params.year || currentYear;
		var ptype = $state.params.type || null;

		$scope.reportID = $state.params.formID || localStorage.getItem('formID');
		$scope.stateName = 'report.sdq.list';

		$scope.years = $time.years();
		$scope.year = $time.yearObjectForYear(pyear);

		$scope.class = null;
		$scope.classes = [];
		$scope.room = null;
		$scope.rooms = [];

		var changeState = function() {
			var params = {
				class: self.class.value,
				room: self.room.value,
				year: self.year.value,
				from: $scope.currentPage * $scope.numRows,
				num : $scope.numRows
			}

			if (ptype) {
				if (ptype == 'school') {
					$state.go('report.sdq.overview', params);
				} else if (ptype == 'room') {
					$state.go('report.sdq.overview', params);
				} else if (ptype == 'class') {
					$state.go('report.sdq.overview', params);
				} else {
					$state.go('report.sdq.list', params);
				}
			} else {
				$state.go('report.sdq.list', params);
			}
		}

		$scope.classChange = function() {
			// $toolbar.valueChange({id:'class', value:$scope.class.value});
			changeState();
		}
		$scope.roomChange = function() {
			// $toolbar.valueChange({id:'room', value:$scope.room.value});
			changeState();
		}
		$scope.yearChange = function() {
			// $toolbar.valueChange({id:'year', value:$scope.year.value});
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
				// changeState();
			}
		})

		// Emit yearChange once if it is pre-determinded
		// and emit only after all angular is loaded
		// if (typeof $scope.year == 'object') {
		// 	setTimeout(function() {
		// 		self.yearChange();
		// 	}, 500);
		// }

		$controller('PaginationController', {$scope: $scope});
	})
























	.controller('SDQReportListController', function($scope, $state, $report){
		var self = this;

		this.form = { id: $state.params.formID || localStorage.getItem('formID') };
		this.from = $state.params.from || 0;
		this.num = $state.params.num || 10;
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

		var payload = { id: this.form.id, year: this.year, from: this.from, num: this.num };
		$report.person(payload, function(participants){
			self.results = self.displays = participants;
			prepareDisplaysData();
		})
	})























	.controller('SDQReportDetailController', function($scope, $state, $participant){
		var self = this;

		var _id = $state.params.formID || localStorage.getItem('formID');

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
					$participant.result(participant.id, _id, self.year, function(res){
						if (res.success) {
							$scope.participant.groups = res.data.groups;
							$scope.participant.chronic = res.data.chronic;
							$scope.participant.notease = res.data.notease;
							$scope.participant.comments = res.data.comments;
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



















	.controller('SDQReportOverviewController', function($scope, $report, $state){
		var self = this;
		var _id = $state.params.formID || null;
		var _class = $state.params.class || null;
		var _room = $state.params.room || null;
		var _year = $state.params.year || null;
		var _type = $state.params.type || null;

		this.results = [];

		var _payload = null;
		var _reportLoader = null;
		var _callback = function(report){
			self.results = report;
		};

		var _reloadData = function() {
			if (_type == 'room') {
				_payload = { id: _id, class: _class, room: _room, year: _year };
				_reportLoader = $report.room;
			} else if (_type == 'class') {
				_payload = { id: _id, class: _class, year: _year };
				_reportLoader = $report.class;
			} else if (_type == 'school') {
				_payload = { id: _id, year: _year };
				_reportLoader = $report.school;
			}

			if (_id) {
				_reportLoader(_payload, _callback);
			}
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