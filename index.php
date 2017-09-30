<?php
session_start();
if(isset($_SESSION['user'])) {
    header('Location: app/index.php');
}
if (!isset($_SESSION['message'])) {
    $_SESSION['message'] = 'Please login with your MyAnimeList credentials to continue.';
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
    <link rel="stylesheet" href="styles/home.css">
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
    <aside id="blurb-dialog" class="mdc-dialog" role="alertdialog" aria-labelledby="my-mdc-dialog-label" aria-describedby="my-mdc-dialog-description">
      <div class="mdc-dialog__surface">
        <header class="mdc-dialog__header">
          <h2 id="my-mdc-dialog-label" class="mdc-dialog__header__title">
            What is Elsie?
          </h2>
        </header>
        <section id="my-mdc-dialog-description" class="mdc-dialog__body">
          Elsie is a Material Design MyAnimeList Web Client. You can browse your anime list, modify entries and search for anime. Additional information is also pulled from AniList that isn't available from MyAnimeList, such as upcoming episode times, official websites and social media accounts for shows.
        </section>
        <footer class="mdc-dialog__footer">
          <a type="button" class="mdc-button mdc-dialog__footer__button mdc-dialog__footer__button--cancel" target="_blank" href="https://github.com/DdcCabuslay/elsie">View on GitHub</a>
          <button type="button" class="mdc-button mdc-dialog__footer__button mdc-dialog__footer__button--accept">Close</button>
        </footer>
      </div>
      <div class="mdc-dialog__backdrop"></div>
    </aside>
    <main>
        <i id="help" class="material-icons">help</i>
        <div id="elsie_circle"></div>
        <div id="title" class="mdc-typography--display3">Elsie</div>
        <div id="server_message" class="mdc-typography--body1"><?= $_SESSION['message']; ?></div>
        <div id="login_form">
            <form action="mal_authenticate.php" method="post" id="mal_login">
                <div class="mdc-textfield">
                    <input type="text" id="mal_user" name="mal_user" class="mdc-textfield__input">
                    <label class="mdc-textfield__label" for="mal_user">Username</label>
                </div><br>
                <div class="mdc-textfield">
                    <input type="password" id="mal_pw" name="mal_pw" class="mdc-textfield__input">
                    <label for="mal_pw" class="mdc-textfield__label">Password</label>
                </div><br><br>
                <input type="submit" class="mdc-button mdc-button--raised mdc-button--primary" value="Login" />
            </form>
        </div>
    </main>        

</body>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script>
    var dialog = new mdc.dialog.MDCDialog(document.querySelector('#blurb-dialog'));

    document.querySelector('#help').addEventListener('click', function (evt) {
      dialog.lastFocusedTarget = evt.target;
      dialog.show();
    });
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