(function() {
    var tfs = document.querySelectorAll('.mdc-textfield:not([data-demo-no-auto-js])');
    for (var i = 0, tf; tf = tfs[i]; i++) {
        mdc.textfield.MDCTextfield.attachTo(tf);
    }
})();