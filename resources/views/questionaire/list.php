<div class="col-xs-12 form-list no-pad bgcolor-secondary full-height">
	<h3 class="col-xs-12 text-center color-accent1 no-margin std-pad theme-border-bottom">แบบฟอร์มประเมิน</h3>
	<div class="col-xs-12 no-pad clickable bgcolor-secondary highlightable" *ngFor="let form of formList">
		<div class="col-xs-12 large-pad no-pad-bottom" (click)="select(form)">
			<div class="col-xs-12 theme-border-bottom large-pad-bottom">
				<h4 class="text-center color-dominant">
					{{ form.name }}
				</h4>
			</div>
		</div>
	</div>
</div>