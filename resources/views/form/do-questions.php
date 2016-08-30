<div ng-repeat="q in form.questions" class="col-xs-12">

	<div ng-if="q.type == 10 || q.type == 3" class="std-pad col-xs-12">
		<div class="col-xs-12">
			{{ q.name }}
		</div>
		<form>
		<div class="col-xs-6" ng-repeat="c in q.choices">
			<input type="radio" ng-click="toggleChoose(q,c)" name="{{q.name}}">
			<span>{{ c.name }}</span>
		</div>
		</form>
	</div>

	<div ng-if="q.type == 2" class="col-xs-12">
		<div class="col-xs-12">
			{{ q.name }}
		</div>
	</div>

	<div ng-if="q.type == 4" class="col-xs-12">
		<div class="col-xs-12">
			{{ q.name }}
		</div>
		<div class="col-xs-12" ng-repeat="c in q.choices">
			<div class="col-xs-4">
				{{ c.name }}
			</div>
			<div class="col-xs-2" ng-repeat="sc in c.subchoices">
				<input type="radio" ng-click="toggleChoose(c,sc)" name="{{c.name}}">
				<span>{{ sc.name }}</span>
			</div>
		</div>
	</div>
	
</div>