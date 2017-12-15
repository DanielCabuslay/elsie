<?php
session_start();
if(!isset($_SESSION['user'])) {
header('Location: ..');
}
$anime_xml = file_get_contents('http://myanimelist.net/malappinfo.php?u=' . $_SESSION['user'] . '&status=all&type=anime');
// $manga_xml = file_get_contents('http://myanimelist.net/malappinfo.php?u=' . $_SESSION['user'] . '&status=all&type=manga');
$anime_data = new SimpleXMLElement($anime_xml);
// $manga_data = new SimpleXMLElement($manga_xml);
?>
<!DOCTYPE html>
<html class="mdc-typography">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title><?php echo $_SESSION['user']; ?>'s Anime List | Elsie</title>
        <link rel="stylesheet" href="https://unpkg.com/material-components-web@0.26.0/dist/material-components-web.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="../styles/style.css">
        <link rel="stylesheet" href="../styles/anime_list.css">
        <link rel="stylesheet" href="../styles/info_dialog.css">
        <link rel="stylesheet" href="../styles/search.css">
        <link rel="stylesheet" href="../styles/theme.css">
        <link rel="icon" type="image/png" href="/images/favicon/favicon.png">
        <link rel="shortcut_icon" href="/images/favicon/favicon.png">
        <link rel="manifest" href="../manifest.json">
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
                    <div class="toolbar_title">
                        <div class="mdc-typography--subheading2">Anime List</div>
                        <div class="mdc-typography--caption"></div>
                    </div>
                    <i id="list_drop_down" class="material-icons mdc-toolbar__menu-icon">arrow_drop_down</i>
                    <div class="mdc-simple-menu" style="position: absolute; top: 12px; left: 12px;" tabindex="-1" id="list_menu">
                        <ul class="mdc-simple-menu__items mdc-list" role="menu" aria-hidden="true">
                            <li class="mdc-list-item" role="menuitem" tabindex="0">Anime List</li>
                            <li class="mdc-list-item" role="menuitem" tabindex="0">Manga List</li>
                        </ul>
                    </div>
                </section>
                <!-- <section id="search_section" class="mdc-toolbar__section">
                    <i class="material-icons mdc-toolbar__menu-icon">search</i>
                    <form id="mal_search">
                        <div class="mdc-text-field" id="search_textfield" data-demo-no-auto-js="">
                            <input type="text" class="mdc-text-field__input" id="search_query" name="search_query" autocomplete="off" placeholder="Search" onkeyup="showResults()">
                        </div>
                    </form>
                    <i id="search_close" class="material-icons mdc-toolbar__menu-icon">close</i>
                </section> -->
                <section class="mdc-toolbar__section mdc-toolbar__section--align-end mdc-toolbar__section--shrink-to-fit" role="toolbar">
                    <!-- <i id="search_button_menu" class="material-icons mdc-toolbar__icon">search</i> -->
                    <i id="options_button" class="material-icons mdc-toolbar__icon">more_vert</i>
                    <div class="mdc-simple-menu mdc-simple-menu--open-from-top-right" style="position: absolute; top: 12px; right: 12px;" tabindex="-1" id="options_menu">
                        <ul class="mdc-simple-menu__items mdc-list" role="menu" aria-hidden="true">
                            <a class="mdc-list-item" role="menuitem" tabindex="0" target="_blank" href="https://myanimelist.net/profile/<?= $_SESSION['user'] ?>">Profile</a>
                            <li id="about_option" class="mdc-list-item" role="menuitem" tabindex="0">About Elsie</li>
                            <a class="mdc-list-item" role="menuitem" tabindex="0" href="logout.php">Switch Users</a>
                        </ul>
                    </div>
                </section>
            </div>
            <div role="progressbar" class="mdc-linear-progress">
                <div class="mdc-linear-progress__buffering-dots"></div>
                <div class="mdc-linear-progress__buffer"></div>
                <div class="mdc-linear-progress__bar mdc-linear-progress__primary-bar">
                    <span class="mdc-linear-progress__bar-inner"></span>
                </div>
                <div class="mdc-linear-progress__bar mdc-linear-progress__secondary-bar">
                    <span class="mdc-linear-progress__bar-inner"></span>
                </div>
            </div>
        </header>

        <?php include 'info_dialog.php' ?>
        <?php include 'about_dialog.php' ?>

        <main class="mdc-toolbar-fixed-adjust">
            <nav id="anime_list_nav" class="mdc-tab-bar mdc-tab-bar--icons-with-text bottom_bar_nav">
                <a id="watching_button" class="mdc-tab mdc-tab--with-icon-and-text mdc-tab--active">
                    <i class="material-icons mdc-tab__icon" aria-hidden="true">play_arrow</i>
                    <span class="mdc-tab__icon-text">Watching</span>
                </a>
                <a id="completed_button" class="mdc-tab mdc-tab--with-icon-and-text">
                    <i class="material-icons mdc-tab__icon" aria-hidden="true">check</i>
                    <span class="mdc-tab__icon-text">Completed</span>
                </a>
                <a id="on_hold_button" class="mdc-tab mdc-tab--with-icon-and-text">
                    <i class="material-icons mdc-tab__icon" aria-hidden="true">pause</i>
                    <span class="mdc-tab__icon-text">On Hold</span>
                </a>
                <a id="dropped_button" class="mdc-tab mdc-tab--with-icon-and-text">
                    <i class="material-icons mdc-tab__icon" aria-hidden="true">remove</i>
                    <span class="mdc-tab__icon-text">Dropped</span>
                </a>
                <a id="ptw_button" class="mdc-tab mdc-tab--with-icon-and-text">
                    <i class="material-icons mdc-tab__icon" aria-hidden="true">add</i>
                    <span class="mdc-tab__icon-text">Plan to Watch</span>
                </a>
                <span class="mdc-tab-bar__indicator"></span>
            </nav>
            <div id="anime_list" class="mdc-typography--body1">
                <div class="mdc-card">
                    <div class="mdc-list-group">
                        <section id="watching_list">
                            <ul class="mdc-list mdc-list--two-line mdc-list--dense">
                                <?php foreach($anime_data->anime as $a):
                                if ($a->my_status == '1'): ?>
                                <li class="mdc-list-item anime_list_item" anime_id="<?= $a->series_animedb_id ?>">
                                    <img class="mdc-list-item__start-detail anime_list_thumb" src="
                                    <?php 
                                        if ($a->series_image == 'https://myanimelist.cdn-dena.com/images/anime//0.jpg') {
                                            echo '../images/unknown.png';
                                        } else {
                                            echo $a->series_image;
                                        }
                                    ?>">
                                    <span class="mdc-list-item__text anime_title"><?= $a->series_title ?>
                                        <span class="mdc-list-item__text__secondary">
                                            <i class="material-icons list-icon">star_rate</i><?= $a->my_score ?>/10
                                            <i class="material-icons list-icon">playlist_add_check</i><?= $a->my_watched_episodes ?>/<?= $a->series_episodes ?>
                                        </span>
                                    </span>
                                </li>
                                <hr class="mdc-list-divider">
                                <?php endif; endforeach; ?>
                            </ul>
                        </section>
                        <section id="completed_list">
                            <ul class="mdc-list mdc-list--two-line mdc-list--dense">
                                <?php foreach($anime_data->anime as $a):
                                if ($a->my_status == '2'): ?>
                                <li class="mdc-list-item anime_list_item" anime_id="<?= $a->series_animedb_id ?>">
                                    <span class="anime_id"><?= $a->series_animedb_id ?></span>
                                    <img class="mdc-list-item__start-detail anime_list_thumb" src="
                                    <?php 
                                        if ($a->series_image == 'https://myanimelist.cdn-dena.com/images/anime//0.jpg') {
                                            echo '../images/unknown.png';
                                        } else {
                                            echo $a->series_image;
                                        }
                                    ?>">
                                    <span class="mdc-list-item__text anime_title"><?= $a->series_title ?>
                                        <span class="mdc-list-item__text__secondary">
                                            <i class="material-icons list-icon">star_rate</i><?= $a->my_score ?>/10
                                            <i class="material-icons list-icon">playlist_add_check</i> <?= $a->series_episodes ?>
                                        </span>
                                    </span>
                                </li>
                                <hr class="mdc-list-divider">
                                <?php endif; endforeach; ?>
                            </ul>
                        </section>
                        <section id="on_hold_list">
                            <ul class="mdc-list mdc-list--two-line mdc-list--dense">
                                <?php foreach($anime_data->anime as $a):
                                if ($a->my_status == '3'): ?>
                                <li class="mdc-list-item anime_list_item" anime_id="<?= $a->series_animedb_id ?>">
                                    <span class="anime_id"><?= $a->series_animedb_id ?></span>
                                    <img class="mdc-list-item__start-detail anime_list_thumb" src="
                                    <?php 
                                        if ($a->series_image == 'https://myanimelist.cdn-dena.com/images/anime//0.jpg') {
                                            echo '../images/unknown.png';
                                        } else {
                                            echo $a->series_image;
                                        }
                                    ?>">
                                    <span class="mdc-list-item__text anime_title"><?= $a->series_title ?>
                                        <span class="mdc-list-item__text__secondary">
                                            <i class="material-icons list-icon">star_rate</i><?= $a->my_score ?>/10
                                            <i class="material-icons list-icon">playlist_add_check</i><?= $a->my_watched_episodes ?>/<?= $a->series_episodes ?>
                                        </span>
                                    </span>
                                </li>
                                <hr class="mdc-list-divider">
                                <?php endif; endforeach; ?>
                            </ul>
                        </section>
                        <section id="dropped_list">
                            <ul class="mdc-list mdc-list--two-line mdc-list--dense">
                                <?php foreach($anime_data->anime as $a):
                                if ($a->my_status == '4'): ?>
                                <li class="mdc-list-item anime_list_item" anime_id="<?= $a->series_animedb_id ?>">
                                    <span class="anime_id"><?= $a->series_animedb_id ?></span>
                                    <img class="mdc-list-item__start-detail anime_list_thumb" src="
                                    <?php 
                                        if ($a->series_image == 'https://myanimelist.cdn-dena.com/images/anime//0.jpg') {
                                            echo '../images/unknown.png';
                                        } else {
                                            echo $a->series_image;
                                        }
                                    ?>">
                                    <span class="mdc-list-item__text anime_title"><?= $a->series_title ?>
                                        <span class="mdc-list-item__text__secondary">
                                            <i class="material-icons list-icon">star_rate</i><?= $a->my_score ?>/10
                                            <i class="material-icons list-icon">playlist_add_check</i><?= $a->my_watched_episodes ?>/<?= $a->series_episodes ?>
                                        </span>
                                    </span>
                                </li>
                                <hr class="mdc-list-divider">
                                <?php endif; endforeach; ?>
                            </ul>
                        </section>
                        <section id="ptw_list">
                            <ul class="mdc-list mdc-list--two-line mdc-list--dense">
                                <?php foreach($anime_data->anime as $a):
                                if ($a->my_status == '6'): ?>
                                <li class="mdc-list-item anime_list_item" anime_id="<?= $a->series_animedb_id ?>">
                                    <span class="anime_id"><?= $a->series_animedb_id ?></span>
                                    <img class="mdc-list-item__start-detail anime_list_thumb" src="
                                    <?php 
                                        if ($a->series_image == 'https://myanimelist.cdn-dena.com/images/anime//0.jpg') {
                                            echo '../images/unknown.png';
                                        } else {
                                            echo $a->series_image;
                                        }
                                    ?>">
                                    <span class="mdc-list-item__text title anime_title"><?= $a->series_title ?>
                                        <span class="mdc-list-item__text__secondary">
                                            <i class="material-icons list-icon">star_rate</i><?= $a->my_score ?>/10
                                            <i class="material-icons list-icon">playlist_play</i><?= $a->my_watched_episodes ?>/<?= $a->series_episodes ?>
                                        </span>
                                    </span>
                                </li>
                                <hr class="mdc-list-divider">
                                <?php endif; endforeach; ?>
                            </ul>
                        </section>
                    </div>
                </div>
            </div>
            <div id="search_background"></div>
            <div id="search_sheet" class="mdc-typography--body1">
                <div id="search_body">
                    <div id="search_results">
                        <ul id="search_results_list" class="mdc-list mdc-list--two-line mdc-list--dense">
                            <!-- handled through mal_search.php -->
                        </ul>
                    </div>
                </div>
            </div>
        </main>
        <div class="loading_splash">
            <div class="mdc-typography--body1">Fetching Anime List...</div>
        </div>
        <div class="mdc-snackbar mdc-snackbar--align-start" aria-live="assertive" aria-atomic="true" aria-hidden="true">
          <div class="mdc-snackbar__text"></div>
          <div class="mdc-snackbar__action-wrapper">
            <button type="button" class="mdc-snackbar__action-button"></button>
          </div>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.4/moment.js"></script>
    <script src="https://unpkg.com/material-components-web@0.26.0/dist/material-components-web.min.js"></script>
    <script src="../scripts/search.js"></script>
    <script src="../scripts/toolbar.js"></script>
    <script src="../scripts/textfield.js"></script>
    <script src="../scripts/options_menu.js"></script>
    <script src="../scripts/fetch.js"></script>
    <script src="../scripts/anilist.js"></script>
    <script src="../scripts/window.js"></script>
    <script src="../scripts/about_dialog.js"></script>
</html>