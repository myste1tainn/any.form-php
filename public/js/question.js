(function(){
	
	var module = angular.module('question', [])

	.service('$question', function($choice){
		this.newInstance = function() {
			return {
				id: -1,
				order: 1,
				label: "1.",
				name: "คำถามใหม่",
				description: "",
				choices: [$choice.newInstance()],
				type: 0,
				choiceAsHeader: false,
				folded: true,
				meta: this.newMeta()
			}
		}

		this.newMeta = function() {
			return {
				id : -1,
				header: this.newHeader()
			}
		}

		this.newHeader = function() {
			return {
				rows: [this.newHeaderRow()]
			}
		}

		this.newHeaderRow = function () {
			return {
				cols: [this.newHeaderCol()]
			}
		}

		this.newHeaderCol = function () {
			return {
				rowspan: 1, colspan: 1, label: 'New Label'
			}
		}
	})

})();