<div class="container" *ngIf="!!form">

	<div class="col-xs-12 std-pad border-bottom">
		<h3 class="text-center no-margin">{{ form.name }}</h3>
	</div>

	<div class="col-xs-12 large-margin-top large-margin-bottom" style="padding: 0">
		<participant-info-form></participant-info-form>
	</div>

	<table class="do">
		<thead form-do-table-header [header]="form.headerObject()"></thead>
		<tbody form-do-table-body></tbody>
	</table>

	<form-do-questions></form-do-questions>

	<button type="submit"
			ng-click="submit()"
			style="margin-bottom: 100px"
			class="pull-right std-margin min-w-100 submit">
		ส่ง
	</button>
</div>