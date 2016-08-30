<tr *ngIf="!!header" *ngFor="let r of header.rows">
	<template *ngFor="let c of r.cols">
		<th [attr.rowspan]="c.rowspan" [attr.colspan]="c.colspan"
			class="bgcolor-secondary theme-border">
			{{ c.label }}
		</th>
	</template>
</tr>
