<div class="col-xs-12 no-pad">
	<div class="col-xs-12 text-small small-pad border-b" 
		 ng-repeat="question in questions"
		 ng-click="selectQuestion(question)">
		<span class="fa fa-check-circle" ng-if="question.groupID"></span>
		<span>{{ question.label }} {{ question.name }}</span>
	</div>
</div>