var ERROR_STRING_1 = 'func not implemented';
function TableView() {
	this.add = function(item) {console.error(ERROR_STRING_1,this)};
	this.delete = function(item) {console.error(ERROR_STRING_1,this)};
	this.select = function(item) {console.error(ERROR_STRING_1,this)};
}
function TableViewDelegate() {
	this.tableViewDidSelectItem = function(tableView, item) {console.error(ERROR_STRING_1,this)};
	this.tableViewDidDeselectItem = function(tableView, item) {console.error(ERROR_STRING_1,this)};
	this.tableViewCommitEditingForItem = function(tableView, editType, item) {console.error(ERROR_STRING_1,this)};
}

function TableViewDataSource() {
	this.itemsForTableView = function(tableView) {console.error(ERROR_STRING_1,this)};
}