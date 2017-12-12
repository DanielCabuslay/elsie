var dialog = new mdc.dialog.MDCDialog(document.querySelector('#info-dialog'));
const snackbar = new mdc.snackbar.MDCSnackbar(document.querySelector('.mdc-snackbar'));
var request;
$('.anime_list_item').click(function() {
    $('.mdc-linear-progress').css('display', 'block');
    clearDialog();
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
          message: 'Unable to fetch data'
        };
        snackbar.show(dataObj);
        $('.mdc-linear-progress').css('display', 'none');
    });
});

function clearDialog() {
    //Clear previous data
    $('#anime_title_info').css('background', 'var(--mdc-theme-primary)');
    $('#anilist_banner').attr('src', '');
    $('#hashtag').text('');
    $('#next_episode').text('');
}

function populateDialog(json) {
    //Image
    if (json['image'][0] == 'https://myanimelist.cdn-dena.com/images/anime//0.jpg') {
        $('#mal_poster').attr('src', '../images/unknown.png');
    } else {
        $('#mal_poster').attr('src', json['image'][0]);        
    }

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
    if (json['episodes'][0] == '0') {
        $('#info_dialog_episodes .mdc-list-item__text__secondary').text('TBA');
    } else {
        $('#info_dialog_episodes .mdc-list-item__text__secondary').text(json['episodes'][0]);
    }

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

    if (json['episodes'][0] == '1' || json['status'][0] != '2') {
        $('#info_dialog_aired .mdc-list-item__text__secondary').text(formatDate(json['start_date'][0]));
    } else {
        $('#info_dialog_aired .mdc-list-item__text__secondary').text(
            formatDate(json['start_date'][0]) + ' to ' + formatDate(json['end_date'][0]));
    }

    //Premiered
        $('#info_dialog_premiered .mdc-list-item__text__secondary').text(getPremieredDate(json['start_date'][0]));

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
        $('#info_dialog_user_start_date .mdc-list-item__text__secondary').text(formatDate(json['user_start_date'][0]));
    }

    //End Date
    if (json['user_end_date'][0] == '0000-00-00') {
        $('#info_dialog_user_end_date .mdc-list-item__text__secondary').text('No date entered');
    } else {
        $('#info_dialog_user_end_date .mdc-list-item__text__secondary').text(formatDate(json['user_end_date'][0]));
    }

    //MAL Link
    $('#mal_link_button').attr('href', 'https://myanimelist.net/anime/' + json['id'][0]);
}

function getPremieredDate(date) {
    var year = date.substr(0, 4);
    var month = date.substr(5, 2);
    if (month == '01' || month == '02' || month == '03') {
        return 'Winter ' + year;
    }
    if (month == '04' || month == '05' || month == '06') {
        return 'Spring ' + year;
    }
    if (month == '07' || month == '08' || month == '09') {
        return 'Summer ' + year;
    }
    if (month == '10' || month == '11' || month == '12') {
        return 'Fall ' + year;
    }
    if (year != '0000') {
        return year;
    }
    return 'TBA';
}

function formatDate(date) {
    var year = date.substr(0, 4);
    var month = date.substr(5, 2);
    var day = date.substr(8, 2);
    if (day.substr(0, 1) == '0') {
        day = day.substr(1, 1);
    }
    var formatted_date = '';
    if (month == '01') {
        formatted_date = 'January ' + day + ', ' + year;
    } else if (month == '02') {
        formatted_date = 'February ' + day + ', ' + year;
    } else if (month == '03') {
        formatted_date = 'March ' + day + ', ' + year;
    } else if (month == '04') {
        formatted_date = 'April ' + day + ', ' + year;
    } else if (month == '05') {
        formatted_date = 'May ' + day + ', ' + year;
    } else if (month == '06') {
        formatted_date = 'June ' + day + ', ' + year;
    } else if (month == '07') {
        formatted_date = 'July ' + day + ', ' + year;
    } else if (month == '08') {
        formatted_date = 'August ' + day + ', ' + year;
    } else if (month == '09') {
        formatted_date = 'September ' + day + ', ' + year;
    } else if (month == '10') {
        formatted_date = 'October ' + day + ', ' + year;
    } else if (month == '11') {
        formatted_date = 'November ' + day + ', ' + year;
    } else if (month == '12') {
        formatted_date = 'December ' + day + ', ' + year;
    } else {
        if (year != '0000') {
            formatted_date = year;
        }
    }
    if (formatted_date.length == 0) {
        formatted_date = 'TBA';
    }
    return formatted_date;
}