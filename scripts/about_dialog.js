var about_dialog = new mdc.dialog.MDCDialog(document.querySelector('#about-dialog'));
document.querySelector('#about_option').addEventListener('click', function(evt) {
  about_dialog.show();
});