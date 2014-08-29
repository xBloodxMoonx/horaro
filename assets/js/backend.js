jQuery(function($) {
	var scheduleColumns, scheduleID, viewModel, items, columns;

	$('#start_date').pickadate({
		formatSubmit: 'yyyy-mm-dd',
		hiddenName: true
	});

	$('#start_time').pickatime({
		interval: 15,
		formatSubmit: 'HH:i',
		hiddenName: true
	});

	$.fn.editable.defaults.mode = 'popup';
	$.fn.editableform.buttons =
		'<button type="submit" class="btn btn-primary btn-xs editable-submit">'+
			'<i class="fa fa-check"></i>'+
		'</button>'+
		'<button type="button" class="btn btn-default btn-xs editable-cancel">'+
			'<i class="fa fa-ban"></i>'+
		'</button>';

	//= src/Utils.js

	//= src/Item.js
	//= src/ItemsViewModel.js
	//
	//= src/Column.js
	//= src/ColumnsViewModel.js

	if (horaro && horaro.schedule) {
		scheduleColumns = horaro.schedule.columns;
		scheduleID      = horaro.schedule.id;

		if (horaro.ui === 'scheduler') {
			items = [];

			if (horaro.schedule.items) {
				horaro.schedule.items.forEach(function(item, idx) {
					items.push(new Item(item[0], item[1], item[2], idx + 1));
				});
			}

			viewModel = new ItemsViewModel(items);
		}
		else if (horaro.ui === 'columnist') {
			columns = [];

			if (horaro.schedule.columns) {
				horaro.schedule.columns.forEach(function(column, idx) {
					columns.push(new Column(column[0], column[1], idx + 1));
				});
			}

			viewModel = new ColumnsViewModel(columns);
		}

		if (viewModel) {
			ko.applyBindings(viewModel);
			viewModel.initDragAndDrop(false);
		}
	}
});