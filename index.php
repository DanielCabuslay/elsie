<?php
session_start();
if(isset($_SESSION['user'])) {
    header('Location: app/index.php');
}
if (!isset($_SESSION['message'])) {
    $_SESSION['message'] = 'Enter your MyAnimeList username.';
}
?>
<!DOCTYPE html>
<html class="mdc-typography">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Elsie</title>
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@0.26.0/dist/material-components-web.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/theme.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="icon" type="image/png" href="/images/favicon/favicon.png">
    <link rel="shortcut_icon" href="/images/favicon/favicon.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#673ab7">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
</head>
<body>
    <main>
        <div id="elsie_circle"></div>
        <div id="title" class="mdc-typography--display3">Elsie</div>
        <div class="mdc-typography--body1">Elsie is a Material Design MyAnimeList Web Client. You can browse your anime list and search for anime.</div>
        <div id="server_message" class="mdc-typography--body1"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <div id="login_form">
            <form action="mal_verify_user.php" method="post" id="mal_login">
                <div class="mdc-text-field">
                    <input type="text" id="mal_user" name="mal_user" maxlength="16" class="mdc-text-field__input">
                    <label class="mdc-text-field__label" for="mal_user">Username</label>
                </div><br>
                <input type="submit" class="mdc-button mdc-button--raised mdc-button--primary" value="Login" />
            </form>
        </div>
    </main>        
</body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://unpkg.com/material-components-web@0.26.0/dist/material-components-web.min.js"></script>
<script src="scripts/textfield.js"></script>
</html>