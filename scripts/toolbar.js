(function() {
    var pollId = 0;
    pollId = setInterval(function() {
        var pos = getComputedStyle(document.querySelector('.mdc-toolbar')).position;
        if (pos === 'fixed' || pos === 'relative') {
            init();
            clearInterval(pollId);
        }
    }, 250);
    function init() {
        var toolbar = mdc.toolbar.MDCToolbar.attachTo(document.querySelector('.mdc-toolbar'));
        toolbar.listen('MDCToolbar:change', function(evt) {
            var flexibleExpansionRatio = evt.detail.flexibleExpansionRatio;
        });
        toolbar.fixedAdjustElement = document.querySelector('.mdc-toolbar-fixed-adjust');
        // toolbar.fixedAdjustElement = document.querySelector('#search_body');
        // toolbarHeight = $('.mdc-toolbar-fixed-adjust').css('margin-top');
        // $('.mdc-toolbar-fixed-adjust').css('height', 'calc(100vh - ' + toolbarHeight + ')');
        // $('#search_body').css('height', 'calc(100vh - ' + toolbarHeight + ')');
    }
})();