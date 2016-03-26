@extends((Request::ajax()) ? 'nilview' : 'app')
@section('content')
<div class="container report do">

	<div class="row report header" style="padding-bottom: 0px">

		<div class="col-xs-12 text-center no-margin std-pad std-margin-bottom noselect" 
			 select-option>
			<span style='cursor: pointer' ng-click="select.toggleExpand()">
				<span>[[form.name || 'เลือกชินดรายงาน']]</span>
				<span class="fa fa-caret-down" style="font-size: 0.7em"></span>
			</span>
			<div ng-if="select.expanded"
				 class="select-box text-left indent-left-1 anim-fade">
				<div class="small-pad item"
					 ng-repeat="f in forms"
					 ng-click="select.select(f)"
					 ng-class="{'selected' : f == form}">
					[[f.name]]
				</div>
			</div>
			<select ng-model="form" class="form-control hide"
					ng-change="stateChange(type)"
					ng-options="form as form.name for form in forms">
			</select>
		</div>

		<div class="row button-bar bar-bottom">
			<button class="col-xs-3 small-pad"
					ng-click="stateChange('person')"
					ng-class="{'selected' : type == 'person'}">
					รายบุคคล
			</button>
			<button class="col-xs-3 small-pad"
					ng-click="stateChange('room')"
					ng-class="{'selected' : type == 'room'}">
					รายห้องเรียน
			</button>
			<button class="col-xs-3 small-pad"
					ng-click="stateChange('class')"
					ng-class="{'selected' : type == 'class'}">
					รายชั้นปี
			</button>
			<button class="col-xs-3 small-pad"
					ng-click="stateChange('school')"
					ng-class="{'selected' : type == 'school'}">
					ภาพรวมทั้งโรงเรียน
			</button>
		</div>

	</div>

	<div class="col-xs-12"
		 ui-view="report.type">
	</div>
	<!-- <div ng-switch="type">
		<room-report ng-switch-when="room"></room-report>
		<class-report ng-switch-when="class"></class-report>
		<school-report ng-switch-when="school"></school-report>
		<person-report ng-switch-default></person-report>
	</div> -->
</div>
@endsection