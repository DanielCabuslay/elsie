var dialog = new mdc.dialog.MDCDialog(document.querySelector('#info-dialog'));
var snackbar = new mdc.snackbar.MDCSnackbar(document.querySelector('.mdc-snackbar'));
var request;
$('.anime_list_item').click(function() {
    $('.mdc-linear-progress').css('display', 'block');
    var id = $(this).attr('anime_id');
    request = $.ajax({
        url: "anime_fetch_info.php",
        type: "post",
        data: {id: id},
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR){
        $('.mdc-dialog__body--scrollable').scrollTop(0);
        fetchAniListData(id);
        populateDialog(response);
        dialog.show();
        $('.mdc-linear-progress').css('display', 'none');
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        var dataObj = {
          message: 'Unable to fetch data',
          actionText: 'Report',
          actionHandler: function () {
            console.error("The following error occurred: "+
                textStatus, errorThrown
            );
          }
        };
        snackbar.show(dataObj);
        $('.mdc-linear-progress').css('display', 'none');
    });
});

function populateDialog(json) {
    //Image
    $('#mal_poster').attr('src', json['image'][0]);

    //Title
    $('#info-dialog .mdc-dialog__header__title').text(json['title'][0]);

    //Type
    if (json['type'][0] == '1') {
        $('#info_dialog_type .mdc-list-item__text__secondary').text('TV');
    }
    else if (json['type'][0] == '2') {
        $('#info_dialog_type .mdc-list-item__text__secondary').text('OVA');
    }
    else if (json['type'][0] == '3') {
        $('#info_dialog_type .mdc-list-item__text__secondary').text('Movie');
    }
    else if (json['type'][0] == '4') {
        $('#info_dialog_type .mdc-list-item__text__secondary').text('Special');
    }
    else if (json['type'][0] == '5') {
        $('#info_dialog_type .mdc-list-item__text__secondary').text('ONA');
    }
    else if (json['type'][0] == '6') {
        $('#info_dialog_type .mdc-list-item__text__secondary').text('Music');
    }

    //Episodes
    $('#info_dialog_episodes .mdc-list-item__text__secondary').text(json['episodes'][0]);

    //Status
    if (json['status'][0] == '1') {
        $('#info_dialog_status .mdc-list-item__text__secondary').text('Currently Airing');
    }
    else if (json['status'][0] == '2') {
        $('#info_dialog_status .mdc-list-item__text__secondary').text('Finished Airing');
    }
    else if (json['status'][0] == '3') {
        $('#info_dialog_status .mdc-list-item__text__secondary').text('Not yet aired');
    }

    if (json['episodes'][0] == '1' || json['status'][0] == '1') {
        $('#info_dialog_aired .mdc-list-item__text__secondary').text(json['start_date'][0]);        
    } else {
        $('#info_dialog_aired .mdc-list-item__text__secondary').text(
            json['start_date'][0] + ' to ' + json['end_date'][0]);           
    }

    //User Status
    if (json['user_status'][0] == '1') {
        $('#info_dialog_user_status .mdc-list-item__text__secondary').text('Watching');
    }
    else if (json['user_status'][0] == '2') {
        $('#info_dialog_user_status .mdc-list-item__text__secondary').text('Completed');
    }
    else if (json['user_status'][0] == '3') {
        $('#info_dialog_user_status .mdc-list-item__text__secondary').text('On Hold');
    }
    else if (json['user_status'][0] == '4') {
        $('#info_dialog_user_status .mdc-list-item__text__secondary').text('Dropped');
    }
    else if (json['user_status'][0] == '6') {
        $('#info_dialog_user_status .mdc-list-item__text__secondary').text('Plan to Watch');
    }

    //User Episodes
    $('#info_dialog_user_episodes .mdc-list-item__text__secondary').text(json['user_episodes'][0]);

    //User Score
    $('#info_dialog_user_score .mdc-list-item__text__secondary').text(json['user_score'][0]);

    //Start Date
    if (json['user_start_date'][0] == '0000-00-00') {
        $('#info_dialog_user_start_date .mdc-list-item__text__secondary').text('No date entered');
    } else {
        $('#info_dialog_user_start_date .mdc-list-item__text__secondary').text(json['user_start_date'][0]);
    }

    //End Date
    if (json['user_end_date'][0] == '0000-00-00') {
        $('#info_dialog_user_end_date .mdc-list-item__text__secondary').text('No date entered');
    } else {
        $('#info_dialog_user_end_date .mdc-list-item__text__secondary').text(json['user_end_date'][0]);
    }
}

$('#info-dialog .mdc-dialog__footer__button--accept').click(function() {
    $('#anime_title_info').css('background-color', 'var(--mdc-theme-primary)');
    $('#anilist_banner').attr('src', '');
    $('#hashtag').text('');
    $('#next_episode').text('');
});