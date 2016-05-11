<div class="container form-list">
	<h3>เลือกแบบฟอร์มที่ต้องการใช้งาน</h3>
	<hr />
	<ul class="col-xs-12">
		<li ng-repeat="questionaire in questionaires" ng-if="list.isNotRisk(questionaire)">
			<a ui-sref="form.do({ formID: questionaire.id, form: questionaire })">
				[[ questionaire.name ]]
			</a>
		</li>
	</ul>
</div>