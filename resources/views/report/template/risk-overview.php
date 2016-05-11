<div class="no-pad" ng-repeat="aspect in report.aspects">
	<div class="col-xs-12 std-pad border-b" ng-if="$index == 0">
		<div class="col-xs-4 border-r">
			<h1 class="col-xs-12 text-right">[[aspect.countHighRisk || 0]]</h1>
			<div class="pull-right">คน เสี่ยง</div>
		</div>
		<h1 class="col-xs-4 text-center space-top">
			[[ aspect.shortName ]]
		</h1>
		<div class="col-xs-4 border-l">
			<h1 class="col-xs-12 text-left">[[aspect.countVeryHighRisk || 0]]</h1>
			<div class="col-xs-12 text-left no-pad">คน มีปัญหา</div>
		</div>
	</div>
	<div class="col-xs-6 std-pad border-b" ng-if="$index > 0 && ($index % 2) == 1">
		<h3 class="col-xs-6">[[ aspect.shortName ]]</h3>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12 text-center">[[aspect.countHighRisk || 0]]</h1>
			<div class="col-xs-12 text-center no-pad">คน เสี่ยง</div>
		</div>
		<div class="col-xs-3 border-l">
			<h1 class="col-xs-12 text-center">[[aspect.countVeryHighRisk || 0]]</h1>
			<div class="col-xs-12 text-center no-pad">คน มีปัญหา</div>
		</div>
	</div>
	<div class="col-xs-6 std-pad border-b l-border-l" ng-if="$index > 0 && ($index % 2) == 0">
		<div class="col-xs-3 border-r">
			<h1 class="col-xs-12 text-center">[[aspect.countVeryHighRisk || 0]]</h1>
			<div class="col-xs-12 text-center no-pad">คน มีปัญหา</div>
		</div>
		<div class="col-xs-3 border-r">
			<h1 class="col-xs-12 text-center">[[aspect.countHighRisk || 0]]</h1>
			<div class="col-xs-12 text-center no-pad">คน เสี่ยง</div>
		</div>
		<h3 class="col-xs-6 text-right">[[ aspect.shortName ]]</h3>
	</div>
</div>