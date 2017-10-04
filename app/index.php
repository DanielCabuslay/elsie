<?php
session_start();
if(!isset($_SESSION['user'])) {
    header('Location: ../index.php');    
}
unset($_SESSION['searchResultsXml']);
$xml = file_get_contents('http://myanimelist.net/malappinfo.php?u=' . $_SESSION['user'] . '&status=all&type=anime');
$data = new SimpleXMLElement($xml);
?>
<!DOCTYPE html>
<html class="mdc-typography">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo $_SESSION['user']; ?>'s Anime List</title>
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/theme.css">
    <link rel="stylesheet" href="../styles/anime_list.css">
    <link rel="stylesheet" href="../styles/search.css">
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
            <span class="mdc-toolbar__title">Watching</span>
        </section>
        <section id="search_section" class="mdc-toolbar__section">
            <i class="material-icons mdc-toolbar__icon--menu">search</i>
            <form id="mal_search">
                <div class="mdc-textfield" id="search_textfield" data-demo-no-auto-js="">
                    <input type="text" class="mdc-textfield__input" id="search_query" name="search_query" autocomplete="off" placeholder="Search" onkeyup="showResults()">
                  </div>
            </form>
            <i id="search_close" class="material-icons mdc-toolbar__icon--menu">close</i>
        </section>
        <section class="mdc-toolbar__section mdc-toolbar__section--align-end" role="toolbar">
            <i id="search_button_menu" class="material-icons mdc-toolbar__icon--menu">search</i>
            <img id="avatar" src="https://myanimelist.cdn-dena.com/images/userimages/<?= $_SESSION['id'] ?>.jpg">
            <div class="mdc-simple-menu" style="position: absolute; top: 12px; right: 12px;" tabindex="-1" id="user_menu">
                <ul class="mdc-simple-menu__items mdc-list" role="menu" aria-hidden="true">
                    <a class="mdc-list-item" role="menuitem" tabindex="0" target="_blank" href="https://myanimelist.net/profile/<?= $_SESSION['user'] ?>">Profile</a>
                    <a class="mdc-list-item" role="menuitem" tabindex="0" href="logout.php">Logout</a>
                </ul>
            </div>
        </section>
      </div>
      <div role="progressbar" class="mdc-linear-progress mdc-linear-progress--indeterminate mdc-linear-progress--accent">
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

    <div class="mdc-toolbar-fixed-adjust">

    <main>
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
            <!-- <span class="mdc-tab-bar__indicator"></span> -->
        </nav>
        <div id="anime_list" class="mdc-typography--body1">
            <div class="mdc-card">
                <div class="mdc-list-group">
                    <section id="watching_list">
                        <ul class="mdc-list mdc-list--two-line mdc-list--dense">
                            <?php foreach($data->anime as $a):
                                if ($a->my_status == '1'): ?>
                                    <li class="mdc-list-item anime_list_item" anime_id="<?= $a->series_animedb_id ?>" anime_title="<?= $a->series_title ?>">
                                        <img class="mdc-list-item__start-detail anime_list_thumb" src="<?= $a->series_image ?>">
                                        <span class="mdc-list-item__text anime_title"><?= $a->series_title ?>
                                            <span class="mdc-list-item__text__secondary">
                                                <i class="material-icons list-icon">star_rate</i><?= $a->my_score ?>/10  
                                                <i class="material-icons list-icon">playlist_add_check</i><?= $a->my_watched_episodes ?>/<?= $a->series_episodes ?>
                                            </span>
                                        </span>
                                        <!-- <span class="mdc-list-item__text__secondary list_options">
                                            <i class="material-icons">add</i>
                                            <i class="material-icons">edit</i>
                                            <i class="material-icons">delete</i>
                                        </span> -->
                                        <i role="button" class="mdc-list-item__end-detail material-icons anime_list_menu_button" onclick="event.preventDefault();">expand_more</i>
                                    </li>
                                    <li class="mdc-list-item anime_list_options" anime_id="<?= $a->series_animedb_id ?>">
                                        <hr class="mdc-list-divider">
                                        <nav class="mdc-tab-bar mdc-tab-bar--icon-tabs">
                                            <a class="mdc-tab anime_list_add">
                                              <i class="material-icons mdc-tab__icon">add</i>
                                            </a>
                                            <a class="mdc-tab anime_list_edit">
                                              <i class="material-icons mdc-tab__icon">edit</i>
                                            </a>
                                            <a class="mdc-tab anime_list_delete">
                                              <i class="material-icons mdc-tab__icon">delete</i>
                                            </a>
                                          </nav>
                                        <hr class="mdc-list-divider">
                                    </li>
                            <?php endif; endforeach; ?>
                        </ul>
                    </section>

                    <section id="completed_list">
                        <ul class="mdc-list mdc-list--two-line mdc-list--dense">
                            <?php foreach($data->anime as $a):
                                if ($a->my_status == '2'): ?>
                                    <li class="mdc-list-item anime_list_item" anime_id="<?= $a->series_animedb_id ?>" anime_title="<?= $a->series_title ?>">
                                        <span class="anime_id"><?= $a->series_animedb_id ?></span>
                                        <img class="mdc-list-item__start-detail anime_list_thumb" src="<?= $a->series_image ?>">
                                        <span class="mdc-list-item__text anime_title"><?= $a->series_title ?>
                                            <span class="mdc-list-item__text__secondary">
                                                <i class="material-icons list-icon">star_rate</i><?= $a->my_score ?>/10  
                                                <i class="material-icons list-icon">playlist_add_check</i> <?= $a->series_episodes ?>
                                            </span>
                                        </span>
                                        <i role="button" class="mdc-list-item__end-detail material-icons anime_list_menu_button" onclick="event.preventDefault();">expand_more</i>
                                    </li>
                                    <li class="mdc-list-item anime_list_options" anime_id="<?= $a->series_animedb_id ?>">
                                        <hr class="mdc-list-divider">
                                        <nav class="mdc-tab-bar mdc-tab-bar--icon-tabs">
                                            <a class="mdc-tab anime_list_add">
                                              <i class="material-icons mdc-tab__icon">add</i>
                                            </a>
                                            <a class="mdc-tab anime_list_edit">
                                              <i class="material-icons mdc-tab__icon">edit</i>
                                            </a>
                                            <a class="mdc-tab anime_list_delete">
                                              <i class="material-icons mdc-tab__icon">delete</i>
                                            </a>
                                          </nav>
                                        <hr class="mdc-list-divider">
                                    </li>
                            <?php endif; endforeach; ?>
                        </ul>
                    </section>

                    <section id="on_hold_list">
                        <ul class="mdc-list mdc-list--two-line mdc-list--dense">
                            <?php foreach($data->anime as $a):
                                if ($a->my_status == '3'): ?>
                                    <li class="mdc-list-item anime_list_item" anime_id="<?= $a->series_animedb_id ?>" anime_title="<?= $a->series_title ?>">
                                        <span class="anime_id"><?= $a->series_animedb_id ?></span>
                                        <img class="mdc-list-item__start-detail anime_list_thumb" src="<?= $a->series_image ?>">
                                        <span class="mdc-list-item__text anime_title"><?= $a->series_title ?>
                                            <span class="mdc-list-item__text__secondary">
                                                <i class="material-icons list-icon">star_rate</i><?= $a->my_score ?>/10  
                                                <i class="material-icons list-icon">playlist_add_check</i><?= $a->my_watched_episodes ?>/<?= $a->series_episodes ?>
                                            </span>
                                        </span>
                                        <i role="button" class="mdc-list-item__end-detail material-icons anime_list_menu_button" onclick="event.preventDefault();">expand_more</i>
                                    </li>
                                    <li class="mdc-list-item anime_list_options" anime_id="<?= $a->series_animedb_id ?>">
                                        <hr class="mdc-list-divider">
                                        <nav class="mdc-tab-bar mdc-tab-bar--icon-tabs">
                                            <a class="mdc-tab anime_list_add">
                                              <i class="material-icons mdc-tab__icon">add</i>
                                            </a>
                                            <a class="mdc-tab anime_list_edit">
                                              <i class="material-icons mdc-tab__icon">edit</i>
                                            </a>
                                            <a class="mdc-tab anime_list_delete">
                                              <i class="material-icons mdc-tab__icon">delete</i>
                                            </a>
                                          </nav>
                                        <hr class="mdc-list-divider">
                            <?php endif; endforeach; ?>
                        </ul>
                    </section>

                    <section id="dropped_list">
                        <ul class="mdc-list mdc-list--two-line mdc-list--dense">
                            <?php foreach($data->anime as $a):
                                if ($a->my_status == '4'): ?>
                                    <li class="mdc-list-item anime_list_item" anime_id="<?= $a->series_animedb_id ?>" anime_title="<?= $a->series_title ?>">
                                        <span class="anime_id"><?= $a->series_animedb_id ?></span>
                                        <img class="mdc-list-item__start-detail anime_list_thumb" src="<?= $a->series_image ?>">
                                        <span class="mdc-list-item__text anime_title"><?= $a->series_title ?>
                                            <span class="mdc-list-item__text__secondary">
                                                <i class="material-icons list-icon">star_rate</i><?= $a->my_score ?>/10  
                                                <i class="material-icons list-icon">playlist_add_check</i><?= $a->my_watched_episodes ?>/<?= $a->series_episodes ?>
                                            </span>
                                        </span>
                                        <i role="button" class="mdc-list-item__end-detail material-icons anime_list_menu_button" onclick="event.preventDefault();">expand_more</i>
                                    </li>
                                    <li class="mdc-list-item anime_list_options" anime_id="<?= $a->series_animedb_id ?>">
                                        <hr class="mdc-list-divider">
                                        <nav class="mdc-tab-bar mdc-tab-bar--icon-tabs">
                                            <a class="mdc-tab anime_list_add">
                                              <i class="material-icons mdc-tab__icon">add</i>
                                            </a>
                                            <a class="mdc-tab anime_list_edit">
                                              <i class="material-icons mdc-tab__icon">edit</i>
                                            </a>
                                            <a class="mdc-tab anime_list_delete">
                                              <i class="material-icons mdc-tab__icon">delete</i>
                                            </a>
                                          </nav>
                                        <hr class="mdc-list-divider">
                            <?php endif; endforeach; ?>
                        </ul>
                    </section>

                    <section id="ptw_list">
                        <ul class="mdc-list mdc-list--two-line mdc-list--dense">
                            <?php foreach($data->anime as $a):
                                if ($a->my_status == '6'): ?>
                                    <li class="mdc-list-item anime_list_item" anime_id="<?= $a->series_animedb_id ?>" anime_title="<?= $a->series_title ?>">
                                        <span class="anime_id"><?= $a->series_animedb_id ?></span>
                                        <img class="mdc-list-item__start-detail anime_list_thumb" src="<?= $a->series_image ?>">
                                        <span class="mdc-list-item__text title anime_title"><?= $a->series_title ?>
                                            <span class="mdc-list-item__text__secondary">
                                                <i class="material-icons list-icon">star_rate</i><?= $a->my_score ?>/10  
                                                <i class="material-icons list-icon">playlist_play</i><?= $a->my_watched_episodes ?>/<?= $a->series_episodes ?>
                                            </span>
                                        </span>
                                        <i role="button" class="mdc-list-item__end-detail material-icons anime_list_menu_button" onclick="event.preventDefault();">expand_more</i>
                                    </li>
                                    <li class="mdc-list-item anime_list_options" anime_id="<?= $a->series_animedb_id ?>">
                                        <hr class="mdc-list-divider">
                                        <nav class="mdc-tab-bar mdc-tab-bar--icon-tabs">
                                            <a class="mdc-tab anime_list_add">
                                              <i class="material-icons mdc-tab__icon">add</i>
                                            </a>
                                            <a class="mdc-tab anime_list_edit">
                                              <i class="material-icons mdc-tab__icon">edit</i>
                                            </a>
                                            <a class="mdc-tab anime_list_delete">
                                              <i class="material-icons mdc-tab__icon">delete</i>
                                            </a>
                                          </nav>
                                        <hr class="mdc-list-divider">
                            <?php endif; endforeach; ?>
                        </ul>
                    </section>

                </div>
            </div>
            <div class="mobile_spacer"></div>
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

    </div>

</body>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script src="../scripts/search.js"></script>
<script src="../scripts/toolbar.js"></script>
<script src="../scripts/textfield.js"></script>
<script src="../scripts/user_menu.js"></script>
<script>
    window.onload = function() {
        $('.mdc-toolbar-fixed-adjust').css('display', 'block');
        $('.mdc-linear-progress').css('display', 'none');
    };
</script>
<script>
    var drawerEl = document.querySelector('.mdc-temporary-drawer');
    var MDCTemporaryDrawer = mdc.drawer.MDCTemporaryDrawer;
    var drawer = new MDCTemporaryDrawer(drawerEl);
    document.querySelector('.menu').addEventListener('click', function() {
        drawer.open = true;
    });
</script>
<script type="text/javascript">
var request;
$('.anime_list_item').click(function() {
    var id = $(this).attr('anime_id');
    var title = $(this).attr('anime_title');
    request = $.ajax({
        url: "anime_fetch_info.php",
        type: "post",
        data: {id: id, title: title}
    });
    request.done(function (response, textStatus, jqXHR){
        // console.log(response);
        window.location.href = 'anime.php?id=' + id;
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

});

</script>
<!-- <script>
  (function() {
    // Delay initialization within development until styles have loaded
    setTimeout(initInteractiveLists, 250);
    function initInteractiveLists() {
      var interactiveListItems = document.querySelectorAll('.anime_list_item');
      for (var i = 0, li; li = interactiveListItems[i]; i++) {
        mdc.ripple.MDCRipple.attachTo(li);
        // Prevent link clicks from jumping demo to the top of the page
        li.addEventListener('click', function(evt) {
          evt.preventDefault();
        });
      }
    }
  })();
</script> -->
<script>
$('#watching_button').click(function() {
    $('#watching_list').css('display', 'block');
    $('#completed_list').css('display', 'none');
    $('#on_hold_list').css('display', 'none');
    $('#dropped_list').css('display', 'none');
    $('#ptw_list').css('display', 'none');
    $('.mdc-toolbar__title').html('Watching');
    window.scrollTo(0, 0);
});
$('#completed_button').click(function() {
    $('#completed_list').css('display', 'block');
    $('#watching_list').css('display', 'none');
    $('#on_hold_list').css('display', 'none');
    $('#dropped_list').css('display', 'none');
    $('#ptw_list').css('display', 'none');
    $('.mdc-toolbar__title').html('Completed');
    window.scrollTo(0, 0);
});
$('#on_hold_button').click(function() {
    $('#on_hold_list').css('display', 'block');
    $('#watching_list').css('display', 'none');
    $('#completed_list').css('display', 'none');
    $('#dropped_list').css('display', 'none');
    $('#ptw_list').css('display', 'none');
    $('.mdc-toolbar__title').html('On Hold');
    window.scrollTo(0, 0);
});
$('#dropped_button').click(function() {
    $('#dropped_list').css('display', 'block');
    $('#watching_list').css('display', 'none');
    $('#completed_list').css('display', 'none');
    $('#on_hold_list').css('display', 'none');
    $('#ptw_list').css('display', 'none');
    $('.mdc-toolbar__title').html('Dropped');
    window.scrollTo(0, 0);
});
$('#ptw_button').click(function() {
    $('#ptw_list').css('display', 'block');
    $('#watching_list').css('display', 'none');
    $('#completed_list').css('display', 'none');
    $('#on_hold_list').css('display', 'none');
    $('#dropped_list').css('display', 'none');
    $('.mdc-toolbar__title').html('Plan to Watch');
    window.scrollTo(0, 0);
});
</script>
<script>
    $('.anime_list_menu_button').click(function(evt) {
      evt.stopPropagation();
      if ($(this).text() == 'expand_more') {
        $(this).text('expand_less');
      } else {
        $(this).text('expand_more');
      }
      // var id = $(this).parent().attr('anime_id');
      var options = $(this).parent().next().slideToggle(0);
      // if (options.css('display') == 'none') {
      //   options.slideDown();
      // } else {
      //   options.slideUp();        
      // }
      // console.log($(this).parent().next('.anime_list_options'));
    });
  </script>
<script>
(function() {
    setTimeout(function () {
      window.navBar = new mdc.tabs.MDCTabBar(document.querySelector('.bottom_bar_nav'));
    },200)
  })();
</script>
</html>