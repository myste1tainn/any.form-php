System.register([], function(exports_1, context_1) {
    "use strict";
    var __moduleName = context_1 && context_1.id;
    var TableHeaderColumn, TableHeaderRow, TableHeader, Form;
    return {
        setters:[],
        execute: function() {
            TableHeaderColumn = (function () {
                function TableHeaderColumn() {
                }
                return TableHeaderColumn;
            }());
            exports_1("TableHeaderColumn", TableHeaderColumn);
            TableHeaderRow = (function () {
                function TableHeaderRow() {
                }
                return TableHeaderRow;
            }());
            exports_1("TableHeaderRow", TableHeaderRow);
            TableHeader = (function () {
                function TableHeader() {
                }
                return TableHeader;
            }());
            exports_1("TableHeader", TableHeader);
            Form = (function () {
                function Form(response) {
                    this.id = response.id;
                    this.parentID = response.parentID;
                    this.name = response.name;
                    this.header = response.header;
                    this.level = response.level;
                }
                return Form;
            }());
            exports_1("Form", Form);
        }
    }
});
