@extends((Request::ajax()) ? 'nilview' : 'app')
@section('content')
<div class="container report do">
	<h3 class="col-xs-1">รายงาน</h3>

	<div class="col-xs-3" style="margin-top: 20px">
		<!-- <select ng-model="activeForm" class="form-control"
				ng-options="form as form.name for form in forms">
		</select> -->
		<select ng-model="form" class="form-control"
				ng-change="stateChange(type)"
				ng-options="form as form.name for form in forms">
		</select>
	</div>

	<div class="col-xs-6" style="margin-top: 20px">
		<!-- <button class="small-pad"
				ng-class="{'selected' : type == 'person'}"
				ng-click="personReport()">
				รายบุคคล
		</button>
		<button class="small-pad"
				ng-class="{'selected' : type == 'room'}"
				ng-click="roomReport()">
				รายห้องเรียน
		</button>
		<button class="small-pad"
				ng-class="{'selected' : type == 'class'}"
				ng-click="classReport()">
				รายชั้นปี
		</button>
		<button class="small-pad"
				ng-class="{'selected' : type == 'school'}"
				ng-click="schoolReport()">
				ภาพรวมทั้งโรงเรียน
		</button> -->
		<button class="small-pad"
				ng-click="stateChange('person')"
				ng-class="{'selected' : type == 'person'}">
				รายบุคคล
		</button>
		<button class="small-pad"
				ng-click="stateChange('room')"
				ng-class="{'selected' : type == 'room'}">
				รายห้องเรียน
		</button>
		<button class="small-pad"
				ng-click="stateChange('class')"
				ng-class="{'selected' : type == 'class'}">
				รายชั้นปี
		</button>
		<button class="small-pad"
				ng-click="stateChange('school')"
				ng-class="{'selected' : type == 'school'}">
				ภาพรวมทั้งโรงเรียน
		</button>
	</div>

	<br /><br /><br /><br />

	<div ui-view="report.type">
	</div>
	<!-- <div ng-switch="type">
		<room-report ng-switch-when="room"></room-report>
		<class-report ng-switch-when="class"></class-report>
		<school-report ng-switch-when="school"></school-report>
		<person-report ng-switch-default></person-report>
	</div> -->
</div>
@endsection