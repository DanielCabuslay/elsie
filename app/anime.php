<?php
session_start();
if(!isset($_SESSION['user'])) {
    header('Location: ../index.php');    
}
$id = $_GET['id'];
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
$searchResults = new SimpleXMLElement($_SESSION['searchResultsXml']);
foreach($searchResults->entry as $a) {
    if ($a->id == $id) {
        $animeInfo = $a;
        break;
    }
}
?>
<!DOCTYPE html>
<html class="mdc-typography">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo $animeInfo->title ?> | Elsie</title>
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/theme.css">
    <link rel="stylesheet" href="../styles/anime.css">
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
            <a href="index.php" class="material-icons mdc-toolbar__icon--menu menu">arrow_back</a>
            <span id="toolbar_title" class="mdc-toolbar__title"><?php echo $animeInfo->title ?></span>
        </section>
        <section class="mdc-toolbar__section mdc-toolbar__section--align-end" role="toolbar">
            <a href="#" id="search_button_menu" class="material-icons mdc-toolbar__icon--menu search_button">search</a>
            <!-- <a href="logout.php" class="mdc-typography--body1 mdc-toolbar__icon">Logout</a> -->
        </section>
      </div>
    </header>

    <div class="mdc-toolbar-fixed-adjust">

    <main>
        <!-- <nav id="anime_list_nav" class="mdc-tab-bar mdc-tab-bar--icons-with-text bottom_bar_nav">
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
        </nav> -->
        <div id="anime_info_section" class="mdc-typography--body1" anime_id="<?= $animeInfo->id ?>">
        <div id="header_image"></div>
            <div class="mdc-card">
                <section id="anime_info_header">
                    <div id="anime_image">
                        <img src="<?= $animeInfo->image ?>">
                    </div>
                    <div id="anime_title_section">
                        <div id="anime_title">
                            <span class="mdc-typography--headline"><?= $animeInfo->title ?></span>
                        </div>
                        <div id="anime_title_info">
                            <span class="mdc-typography--body1"><?= $animeInfo->status ?></span>
                            <span class="mdc-typography--body1"><?= $animeInfo->type ?></span>
                            <span class="mdc-typography--body1"><?= $animeInfo->episodes ?> episodes</span>
                            <span id="anime_rating">
                                <i class="material-icons list-icon">star_rate</i>
                                <span class="mdc-typography--body1"><?= $animeInfo->score ?></span>
                            </span>
                        </div>
                    </div>
                </section>
                <section id="anime_description">
                    <div id="description"><?= $animeInfo->synopsis ?></div>
                </section>
                <section id="extra_detail_section">
                    <div id="extra_details">
                        <?php if(strlen($animeInfo->synonyms) > 0): ?>   
                            <div id="anime_title_synonyms">
                                <span class="mdc-typography--body2">Alternative Titles</span><br>
                                <span class="mdc-typography--body1"><?= $animeInfo->synonyms ?></span>
                            </div>
                        <?php endif; ?>
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
                <div><?= $userInfo->my_watched_episodes ?></div>
                <div><?= $userInfo->my_start_date ?></div>
                <div><?= $userInfo->my_finish_date ?></div>
                <div><?= $userInfo->my_score ?></div>
                <div><?= $userInfo->my_status ?></div>
                <div><?= $userInfo->my_rewatching ?></div>
                <div><?= $userInfo->my_rewatching_ep ?></div>
                <div><?= $userInfo->my_last_updated ?></div>
                <div><?= $userInfo->my_tags ?></div>
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
<script src="../scripts/textfield.js"></script>
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
    console.log(data);
    var bgUrl = data['data']['Media']['bannerImage'];
    $('#header_image').css('background-image', 'url(' + bgUrl + ')');
    // var json = JSON.parse(data);
}

function handleError(error) {
    alert('Error, check console');
    console.error(error);
}
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
(function() {
    setTimeout(function () {
      window.navBar = new mdc.tabs.MDCTabBar(document.querySelector('.bottom_bar_nav'));
    },200)
  })();
</script>
</html>