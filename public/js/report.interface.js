var ERROR_STRING_1 = 'func not implemented';
function ReportNavigationDataSource() {
	this.classesForNavigationController = function(nav) { console.error(ERROR_STRING_1,this); };
	this.roomsForNavigationController = function(nav) { console.error(ERROR_STRING_1,this); };
	this.yearForNavigationController = function(nav) { console.error(ERROR_STRING_1,this); };
}

function ReportPagingationDataSource() {
	ReportNavigationDataSource.call(this);
	this.pagesForNavigationController = function(nav) { console.error(ERROR_STRING_1, this); };
}

function ReportNavigationControllerDelegate() {
	this.navigationControllerDidChangeClass = function(nav, clazz) {console.error(ERROR_STRING_1,this)};
	this.navigationControllerDidChangeRoom = function(nav, room) {console.error(ERROR_STRING_1,this)};
	this.navigationControllerDidChangeYear = function(nav, year) {console.error(ERROR_STRING_1,this)};
	this.navigationControllerDidChangePage = function(nav, page) {console.error(ERROR_STRING_1,this)};
}

function ReportFormSelectionDelegate() {
	this.formSelectionDidChangeForm = function(selection, form, isLoaded) {console.error('n/a', this)};
	this.typeSelectionDidChangeType = function(selection, type) {console.error('n/a', this)};
}