(function() {
    var tfs = document.querySelectorAll('.mdc-text-field:not([data-demo-no-auto-js])');
    for (var i = 0, tf; tf = tfs[i]; i++) {
      mdc.textField.MDCTextField.attachTo(tf);
    }
})();

$('#mal_login').submit(function() {
	var submit = $(this).find(".mdc-button");
	submit.prop("disabled", true);
});