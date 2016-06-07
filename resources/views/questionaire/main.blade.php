<div class="col-xs-12 form-list no-pad bgcolor-secondary full-height">
	<h3 class="col-xs-12 text-center color-accent1 no-margin std-pad theme-border-bottom">แบบฟอร์มประเมินตนเอง</h3>
	<div class="col-xs-12 no-pad clickable bgcolor-secondary highlightable"
		 ng-repeat="questionaire in questionaires" ng-if="list.isNotRisk(questionaire)" 
		 ui-sref="form.do({ formID: questionaire.id, form: questionaire })">
		<div class="col-xs-12 large-pad no-pad-bottom">
			<div class="col-xs-12 theme-border-bottom large-pad-bottom">
				<h4 class="text-center color-dominant">
					[[ questionaire.name ]]
				</h4>
			</div>
		</div>
	</div>
</div>