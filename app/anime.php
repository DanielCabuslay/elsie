<?php
session_start();
if(!isset($_SESSION['user'])) {
    header('Location: ../index.php');    
}
$id = $_GET['id'];

$searchResults = new SimpleXMLElement($_SESSION['searchResultsXml']);
foreach($searchResults->entry as $a) {
    if ($a->id == $id) {
        $animeInfo = $a;
        break;
    }
}

$userListXml = file_get_contents('http://myanimelist.net/malappinfo.php?u=' . $_SESSION['user'] . '&status=all&type=anime');

$userList = new SimpleXMLElement($userListXml);
$userSaved = false;
foreach($userList->anime as $a) {
    if ($a->series_animedb_id == $id) {
        $userInfo = $a;
        $userSaved = true;
        break;
    }
}
?>
<!DOCTYPE html>
<html class="mdc-typography">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= $animeInfo->title ?> Details | Elsie</title>
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/theme.css">
    <link rel="stylesheet" href="../styles/anime.css">
    <link rel="stylesheet" href="../styles/search.css">
    <link rel="stylesheet" href="../styles/edit_user_details_dialog.css">
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

    <header id="main_toolbar" class="mdc-toolbar mdc-toolbar--fixed">
      <div class="mdc-toolbar__row">
        <section class="mdc-toolbar__section mdc-toolbar__section--align-start">
            <a href="index.php" class="material-icons mdc-toolbar__icon--menu menu">arrow_back</a>
            <span id="toolbar_title" class="mdc-toolbar__title"><?= $animeInfo->title ?></span>
        </section>
        <section class="mdc-toolbar__section mdc-toolbar__section--align-end" role="toolbar">
            <a href="#" id="search_button_menu" class="material-icons mdc-toolbar__icon--menu search_button">search</a>
            <!-- <a href="logout.php" class="mdc-typography--body1 mdc-toolbar__icon">Logout</a> -->
        </section>
      </div>
    </header>

    <div class="mdc-toolbar-fixed-adjust">

        <aside id="add_dialog" class="mdc-dialog" role="alertdialog" aria-labelledby="my-mdc-dialog-label" aria-describedby="my-mdc-dialog-description">
          <div class="mdc-dialog__surface">
            <header class="mdc-dialog__header">
              <h2 id="my-mdc-dialog-label" class="mdc-dialog__header__title">
                Add Anime?
              </h2>
            </header>
            <section id="my-mdc-dialog-description" class="mdc-dialog__body">
              Add <?= $animeInfo->title ?> to your list?
            </section>
            <footer class="mdc-dialog__footer">
              <button type="button" class="mdc-button mdc-dialog__footer__button mdc-dialog__footer__button--cancel">No</button>
              <button type="button" class="mdc-button mdc-dialog__footer__button mdc-dialog__footer__button--accept">Yes</button>
            </footer>
          </div>
          <div class="mdc-dialog__backdrop"></div>
        </aside>

        <?php include 'edit_dialog.php' ?>

    <main>
        <div id="anime_info_section" class="mdc-typography--body1" anime_id="<?= $animeInfo->id ?>">
        <div id="header_image"></div>
            <div class="mdc-card">
                <section id="anime_info_header">
                    <div id="anime_image">
                        <img id="image" src="<?= $animeInfo->image ?>">
                    </div>
                    <div id="anime_title_section">
                        <div id="anime_title">
                            <span class="mdc-typography--title"><?= $animeInfo->title ?></span>
                        </div>
                        <div id="anime_title_info">
                            <span class="mdc-typography--caption">
                                <?php 
                                $seasonNum = substr($animeInfo->start_date, 5, 2);
                                $year = substr($animeInfo->start_date, 0, 4);
                                if ($seasonNum == '01' || $seasonNum == '02' || $seasonNum == '03') {
                                    echo 'Winter ' . $year;
                                } else if ($seasonNum == '04' || $seasonNum == '05' || $seasonNum == '06') {
                                    echo 'Spring ' . $year;
                                } else if ($seasonNum == '07' || $seasonNum == '08' || $seasonNum == '09') {
                                    echo 'Summer ' . $year;
                                } else if ($seasonNum == '10' || $seasonNum == '11' || $seasonNum == '12') {
                                    echo 'Fall ' . $year;
                                } else {
                                    echo $year;
                                }
                                 ?>
                            </span>
                            <span class="mdc-typography--caption"><?= $animeInfo->episodes ?> episodes</span>
                        </div>
                        <div id="anime_scores">
                            <span id="anime_rating">
                                <i class="material-icons list-icon">star_rate</i>
                                <span class="mdc-typography--body1"><?= $animeInfo->score ?></span>
                            </span>
                        </div>
                    </div>
                </section>

                <hr class="mdc-list-divider">

                <?php if($userSaved): ?>
                    <button id="anime_fab" class="mdc-fab material-icons">
                        <span class="mdc-fab__icon">edit</span>
                    </button>
                <?php else: ?>
                    <button id="anime_fab" class="mdc-fab material-icons">
                        <span class="mdc-fab__icon">add</span>
                    </button>
                <?php endif;?>

                <section id="anime_description">
                    <div id="description">
                        <span class="mdc-typography--body2">Description</span><br>
                        <?php if (strlen($animeInfo->synopsis) == 0) {
                            echo 'No synopsis information has been added for this title.';
                        } else {
                            echo preg_replace('#\[i\](.+)\[\/i\]#iUs', '<span class="mdc-typography--body2">$1</span>', $animeInfo->synopsis);
                        } ?>        
                        </div>
                </section>

                <hr class="mdc-list-divider">

                <section id="extra_detail_section">
                    <div id="extra_details">
                        <?php if(strlen($animeInfo->synonyms) > 0): ?>   
                            <div id="anime_title_synonyms">
                                <span class="mdc-typography--body2">Alternative Titles</span><br>
                                <span class="mdc-typography--body1"><?= $animeInfo->synonyms ?></span>
                            </div>
                        <?php endif; ?>
                        <div id="type">
                            <span class="mdc-typography--body2">Type</span><br>
                            <span class="mdc-typography--body1"><?= $animeInfo->type ?></span>
                        </div>
                        <div id="status">
                            <span class="mdc-typography--body2">Status</span><br>
                            <span class="mdc-typography--body1"><?= $animeInfo->status ?></span> 
                        </div>
                        <div id="start_date">
                            <span class="mdc-typography--body2">Start Date</span><br>
                            <span class="mdc-typography--body1"><?= $animeInfo->start_date ?></span>
                        </div>
                        <?php if($animeInfo->end_date != '0000-00-00'): ?>   
                            <div id="end_date">
                                <span class="mdc-typography--body2">End Date</span><br>
                                <span class="mdc-typography--body1"><?= $animeInfo->end_date ?></span>
                            </div>
                        <?php endif; ?>

                    </div>
                </section>
            </div>
        </div>

        <?php include 'search.php' ?>

    </main>        

    </div>

</body>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<script src="../scripts/search.js"></script>
<!-- <script src="../scripts/toolbar.js"></script> -->
<script src="../scripts/textfield.js"></script>
<script>
var offset = $('#anime_title').offset().top;
$('.mdc-toolbar-fixed-adjust').scroll(function() {
    if($(this).scrollTop() > offset) {
        $('#main_toolbar').addClass('opaque');
        $('#toolbar_title').fadeIn(100);
    } else {
        $('#main_toolbar').removeClass('opaque');
        $('#toolbar_title').fadeOut(100);
    }
});
</script>
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
        // toolbar.fixedAdjustElement = document.querySelector('.mdc-toolbar-fixed-adjust');
        toolbar.fixedAdjustElement = document.querySelector('#search_body');
        toolbarHeight = $('#search_body').css('margin-top');
        $('#search_body').css('height', 'calc(100vh - ' + toolbarHeight + ')');
    }
})();
</script>
<script>
var query = `
query ($idMal: Int) {
  Media (idMal: $idMal, type: ANIME) {
    id
    hashtag
    bannerImage
  }
}
`;
var variables = {
    idMal: $('#anime_info_section').attr('anime_id')
};

var url = 'https://graphql.anilist.co',
    options = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            query: query,
            variables: variables
        })
    };
fetch(url, options).then(handleResponse)
                   .then(handleData)
                   .catch(handleError);

function handleResponse(response) {
    return response.json().then(function (json) {
        return response.ok ? json : Promise.reject(json);
    });
}

function handleData(data) {
    var bgUrl = data['data']['Media']['bannerImage'];
    if (bgUrl != null) {
        $('#header_image').css('background-image', 'url(' + bgUrl + ')');
    }
    // var json = JSON.parse(data);
}

function handleError(error) {
    alert('Error, check console');
    console.error(error);
}
</script>
<script>
document.querySelector('#anime_fab').addEventListener('click', function (evt) {
    // $('#anime_fab').fadeOut('fast');
    if ($('#anime_fab span').text() == 'edit') {
        var dialog = new mdc.dialog.MDCDialog(document.querySelector('#edit_dialog'));
    } else {
        var dialog = new mdc.dialog.MDCDialog(document.querySelector('#add_dialog'));
    }
    dialog.lastFocusedTarget = evt.target;
    dialog.show();     
})
</script>
</html>