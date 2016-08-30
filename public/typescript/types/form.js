System.register([], function(exports_1, context_1) {
    "use strict";
    var __moduleName = context_1 && context_1.id;
    var Form, FormDoTableCell, FormDoTableRow, FormDoTableHeader;
    return {
        setters:[],
        execute: function() {
            Form = (function () {
                function Form(data) {
                    var parsedObject = data.json();
                    this.id = parsedObject.id;
                    this.name = parsedObject.name;
                    this.header = parsedObject.header;
                    this.level = parsedObject.level;
                }
                Form.prototype.headerObject = function () {
                    return JSON.parse(this.header);
                };
                return Form;
            }());
            exports_1("Form", Form);
            FormDoTableCell = (function () {
                function FormDoTableCell() {
                }
                return FormDoTableCell;
            }());
            exports_1("FormDoTableCell", FormDoTableCell);
            FormDoTableRow = (function () {
                function FormDoTableRow() {
                }
                return FormDoTableRow;
            }());
            exports_1("FormDoTableRow", FormDoTableRow);
            FormDoTableHeader = (function () {
                function FormDoTableHeader() {
                }
                return FormDoTableHeader;
            }());
            exports_1("FormDoTableHeader", FormDoTableHeader);
        }
    }
});
