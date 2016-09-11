<div class="col-xs-12 no-pad">
	<input class="col-xs-12" ng-model="filterText" />
	<div class="col-xs-12 text-small small-pad border-b one-line" 
		 ng-repeat="question in questions | filter: filterText"
		 ng-click="selectQuestion(question)">
		<span class="fa fa-check-circle" ng-if="question.groupID"></span>
		<span class="one-line">{{ question.label }} {{ question.name }}</span>
	</div>
</div>