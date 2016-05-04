<div class="container report do">

	<div class="row report header" style="padding-bottom: 0px">

		<div class="col-xs-12 text-center no-margin std-pad std-margin-bottom noselect">
			<span style='cursor: pointer' ng-click="nav.toggleExpand()">
				<span>[[nav.form.name || 'เลือกชนิดรายงาน']]</span>
				<span class="fa fa-caret-down" style="font-size: 0.7em"></span>
			</span>
			<div ng-if="nav.expanded"
				 class="select-box text-left indent-left-1 anim-fade">
				<div class="small-pad item"
					 ng-repeat="f in nav.forms"
					 ng-click="nav.select(f)"
					 ng-class="{'selected' : f.id == nav.form.id}">
					[[f.name]]
				</div>
			</div>
			<select ng-model="form" class="form-control hide"
					ng-change="nav.selectType(type)"
					ng-options="form as form.name for form in nav.forms">
			</select>
		</div>

		<div class="row button-bar bar-bottom" ui-view="type-selector">
			<button class="col-xs-3 small-pad"
					ng-click="nav.selectType('person')"
					ng-class="{'selected' : nav.type == 'person'}">
					รายบุคคล
			</button>
			<button class="col-xs-3 small-pad"
					ng-click="nav.selectType('room')"
					ng-class="{'selected' : nav.type == 'room'}">
					รายห้องเรียน
			</button>
			<button class="col-xs-3 small-pad"
					ng-click="nav.selectType('class')"
					ng-class="{'selected' : nav.type == 'class'}">
					รายชั้นปี
			</button>
			<button class="col-xs-3 small-pad"
					ng-click="nav.changeType('school')"
					ng-class="{'selected' : nav.type == 'school'}">
					ภาพรวมทั้งโรงเรียน
			</button>
		</div>

	</div>

	<div class="row" ui-view="report">
		
	</div>
	<!-- <div ng-switch="type">
		<room-report ng-switch-when="room"></room-report>
		<class-report ng-switch-when="class"></class-report>
		<school-report ng-switch-when="school"></school-report>
		<person-report ng-switch-default></person-report>
	</div> -->
</div>