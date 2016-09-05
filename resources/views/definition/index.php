<style type="text/css">
	.selected, .selected * {
		transition: 0.2s all ease;
		background: #555 !important;
	}
</style>
<definition-form class="col-xs-12 no-pad bgcolor-tertiary children full-height">
	<h3 class="col-xs-12 std-pad no-margin text-center">Definitions Administration</h3>
	<hr class="border-color-tertiary-tinted col-xs-12 no-margin" />
	<div class="col-xs-3 no-pad border-right border-color-tertiary-tinted full-height">
		<div class="col-xs-12 border-bottom border-color-tertiary-tinted">
			<p class="pull-left std-pad-tb no-margin">Definition</p>
			<button class="pull-right std-pad-tb" ng-click="definitionForm.add()">Add</button>
		</div>
		<table-view class="col-xs-12 no-pad"
					table-view-id="definitionList"
					table-view-id="definitionList"
					table-view-delegate="definitionForm"
					table-view-data-source="definitionForm"
					table-view-cell-directive="definition-cell">
		</table-view>
	</div>
	<div class="col-xs-3 no-pad border-right border-color-tertiary-tinted full-height">
		<div class="col-xs-12 border-bottom border-color-tertiary-tinted">
			<p class="pull-left std-pad-tb no-margin">Table</p>
		</div>
		<table-view class="col-xs-12 no-pad"
					table-view-id="tableNameList"
					table-view-delegate="definitionForm"
					table-view-data-source="definitionForm"
					table-view-cell-directive="table-name-cell">
		</table-view>
	</div>
	<div class="col-xs-3 no-pad border-right border-color-tertiary-tinted full-height">
		<div class="col-xs-12 border-bottom border-color-tertiary-tinted">
			<p class="pull-left std-pad-tb no-margin">Column</p>
		</div>
		<table-view class="col-xs-12 no-pad"
					table-view-id="columnNameList"
					table-view-delegate="definitionForm"
					table-view-data-source="definitionForm"
					table-view-cell-directive="column-name-cell">
		</table-view>
	</div>
	<div class="col-xs-3 no-pad border-right border-color-tertiary-tinted full-height">
		<div class="col-xs-12 border-bottom border-color-tertiary-tinted">
			<p class="pull-left std-pad-tb no-margin">Values</p>
		</div>
		<table-view class="col-xs-12 no-pad"
					table-view-id="valueList"
					table-view-delegate="definitionForm"
					table-view-data-source="definitionForm"
					table-view-cell-directive="value-cell"
					table-view-multiselection="true">
		</table-view>
	</div>
</definition-form>