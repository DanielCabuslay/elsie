<?php
session_start();
if(isset($_SESSION['user'])) {
    header('Location: app/index.php');
}
?>
<!DOCTYPE html>
<html class="mdc-typography">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Elsie</title>
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/theme.css">
    <link rel="icon" type="image/png" href="/images/favicon/favicon.png">
    <link rel="shortcut_icon" href="/images/favicon/favicon.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#0d47a1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
</head>
<body>

    <header class="mdc-toolbar mdc-toolbar--fixed">
      <div class="mdc-toolbar__row">
        <section class="mdc-toolbar__section mdc-toolbar__section--align-start">
            <!-- <a href="#" class="material-icons mdc-toolbar__icon--menu menu">menu</a> -->
            <span class="mdc-toolbar__title">Elsie</span>
        </section>
        <section class="mdc-toolbar__section mdc-toolbar__section--align-end" role="toolbar">
        </section>
      </div>
    </header>

    <div class="mdc-toolbar-fixed-adjust">

    <main>
        <form action="mal_authenticate.php" method="post" id="mal_login">
            <div class="mdc-textfield">
                <input type="text" id="mal_user" name="mal_user" class="mdc-textfield__input">
                <label class="mdc-textfield__label" for="mal_user">Username</label>
            </div>
            <div class="mdc-textfield">
                <input type="password" id="mal_pw" name="mal_pw" class="mdc-textfield__input">
                <label for="mal_pw" class="mdc-textfield__label">Password</label>
            </div>
            <input type="submit" class="mdc-button" value="Login" />
        </form>
    </main>        

    </div>

</body>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script>
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
    }
})();
</script>
<script>
    (function() {
        var tfs = document.querySelectorAll('.mdc-textfield:not([data-demo-no-auto-js])');
        for (var i = 0, tf; tf = tfs[i]; i++) {
            mdc.textfield.MDCTextfield.attachTo(tf);
        }
    })();
</script>
</html>
</html>