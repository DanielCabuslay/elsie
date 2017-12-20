const about_dialog = new mdc.dialog.MDCDialog(document.querySelector('#about-dialog'));
const info_dialog = new mdc.dialog.MDCDialog(document.querySelector('#info-dialog'));
document.querySelector('#about_option').addEventListener('click', function(evt) {
  about_dialog.show();
});