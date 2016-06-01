(function(){
	
	var module = angular.module('report.sdq', [])

	.controller('SDQReportToolbarController', function(
		$scope, $state, $time, $class, $report, SDQ_ID){


		var self = this;
		var currentYear = (new Date()).getFullYear() + 543;
		var pyear = $state.params.year || currentYear;
		var ptype = $state.params.type || null;
		this.years = $time.years();
		this.year = $time.yearObjectForYear(pyear);

		this.class = null;
		this.classes = [];
		this.room = null;
		this.rooms = [];

		this.numRows = 10;
		this.numPage = 0;
		this.pages = [];
		this.currentPage = 0;

		$report.numberOfPages(SDQ_ID, this.year.value, this.numRows, function(numPage){
			self.pages = [];
			self.numPage = numPage || 0;

			for (var i = 0; i <= 7; i++) {
				self.pages.push(i);
			}
		})

		var changeState = function() {
			var params = {
				class: self.class.value,
				room: self.room.value,
				year: self.year.value,
				from: this.currentPage * this.numRows,
				num : this.numRows
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

		this.changePage = function(page) {
			this.currentPage = page;
			var params = {
				class: self.class.value,
				room: self.room.value,
				year: self.year.value,
				from: this.currentPage * this.numRows,
				num : this.numRows
			};

			var last = this.pages.length - 1;
			if (this.currentPage == this.pages[last]) {
				this.pages.shift();
				this.pages.push(this.pages[last - 1] + 1);
			}
			if (this.currentPage == this.pages[0] && this.pages[0] != 0) {
				for (var i = this.pages.length - 1; i >= 0; i--) {
					this.pages[i]--;
				}
			}

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
				// changeState();
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

		var payload = { id: SDQ_ID, year: this.year, from: this.from, num: this.num };
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



















	.controller('SDQReportOverviewController', function($scope, $report, $state, SDQ_ID){
		var self = this;
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
				_payload = { id: SDQ_ID, class: _class, room: _room, year: _year };
				_reportLoader = $report.room;
			} else if (_type == 'class') {
				_payload = { id: SDQ_ID, class: _class, year: _year };
				_reportLoader = $report.class;
			} else if (_type == 'school') {
				_payload = { id: SDQ_ID, year: _year };
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