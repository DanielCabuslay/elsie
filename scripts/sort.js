$('#sort-dialog .mdc-list-item input').click(function(evt) {
	evt.stopPropagation();
	getSortValue();
	fetchList(getCurrentList());
	sort_dialog.close();
});

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
	if ($('#score-asec-radio').prop('checked') == true) {
		return 5;
	}
	if ($('#score-desc-radio').prop('checked') == true) {
		return 6;
	}
}