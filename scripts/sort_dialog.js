$('#sort-dialog .mdc-list-item input').click(function(evt) {
	evt.stopPropagation();
	getSortValue();
	fetchList(getCurrentList());
	sort_dialog.close();
});

// $('#sort-dialog .mdc-list-item').click(function() {
// 	if ($(this).find('input').prop('checked') == true) {
// 		$(this).find('input').prop('checked', false);
// 	} else {
// 		$(this).find('input').prop('checked', true);
// 	}
// 	getSortValue();
// 	sort_dialog.close();
// });

function getSortValue() {
	if ($('#title-radio').prop('checked') == true) {
		return 1;
	}
	if ($('#type-radio').prop('checked') == true) {
		return 2;
	}
	if ($('#episode-radio').prop('checked') == true) {
		return 3;
	}
	if ($('#status-radio').prop('checked') == true) {
		return 4;
	}
}

function sort(element) {
	getSortValue();
	sort_dialog.close();
}