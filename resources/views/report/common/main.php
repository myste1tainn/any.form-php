<div class="container col-xs-12 report do">

	<div class="row report header" style="padding-bottom: 0px">

		<div class="col-xs-12 text-center no-margin std-pad std-margin-bottom noselect">
			<span style='cursor: pointer' ng-click="toggleExpand()">
				<span>{{selectedForm.name || 'เลือกชนิดรายงาน'}}</span>
				<span class="fa fa-caret-down" style="font-size: 0.7em"></span>
			</span>
			<div ng-if="expanded"
				 class="select-box text-left indent-left-1 anim-fade">
				<div class="small-pad item"
					 ng-repeat="form in forms"
					 ng-click="selectForm(form)"
					 ng-class="{'selected' : form.id == selectedForm.id}">
					{{form.name}}
				</div>
			</div>
			<select ng-model="form" class="form-control hide"
					ng-change="selectForm(form)"
					ng-options="form as selectedForm.name for form in forms">
			</select>
		</div>

		<div class="row button-bar bar-bottom" ui-view="type-selector">
			<button class="col-xs-3 small-pad"
					ng-repeat="type in types"
					ng-click="selectType(type)"
					ng-class="{'selected' : selectedType == type}">
					{{type.name}}
			</button>
		</div>

	</div>

	<div class="col-xs-12" ui-view="report-navigator"></div>
	<div class="col-xs-12 no-pad" ui-view="report-body" ng-controller="ReportDisplayController"></div>

</div>