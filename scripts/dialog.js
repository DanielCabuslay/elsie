const about_dialog = new mdc.dialog.MDCDialog(document.querySelector('#about-dialog'));
const info_dialog = new mdc.dialog.MDCDialog(document.querySelector('#info-dialog'));
const sort_dialog = new mdc.dialog.MDCDialog(document.querySelector('#sort-dialog'));
document.querySelector('#about_option').addEventListener('click', function(evt) {
  about_dialog.show();
});
document.querySelector('#sort_button').addEventListener('click', function(evt) {
  sort_dialog.show();
});