var request;

function fetchAnime(id) {
    linearProgress.progress = 0;
    linearProgress.determinate = false;
    $('.mdc-linear-progress').css('display', 'block');
    clearDialog();
    request = $.ajax({
        url: "anime_fetch_info.php",
        type: "post",
        data: {id: id},
        dataType: "json"
    });
    request.done(function (response) {
        linearProgress.determinate = true;
        $('.mdc-dialog__body--scrollable').scrollTop(0);

        $.when(populateDialog(response)).then(function() {
            info_dialog.show();
            $('.mdc-linear-progress').fadeOut(500);
        });
    });
    request.fail(function (jqXHR, textStatus, errorThrown) {
        var dataObj = {
          message: 'Unable to fetch data'
        };
        snackbar.show(dataObj);
        $('.mdc-linear-progress').fadeOut(500);
    });
}

function fetchList(status) {
    linearProgress.progress = 0;
    linearProgress.determinate = false;
    $('#anime_list').fadeOut(100);
    $('.loading_splash').delay(100).fadeIn(100);
    $('.mdc-linear-progress').css('display', 'block');
    request = $.ajax({
        url: "fetch_list.php",
        type: "post",
        data: {status: status, sort: getSortValue()},
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR){
        linearProgress.determinate = true;
        $('#anime_list .mdc-list').empty();
        $.when(populateList(response)).then(function() {
            $('.loading_splash').fadeOut(100);
            $('#anime_list').delay(100).fadeIn(100);
            $('.mdc-linear-progress').fadeOut(500);
            setTimeout(function() {
                $('#anime_list .anime_list_thumb').lazy();
            }, 100);
        });
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        var dataObj = {
          message: 'Unable to fetch data'
        };
        snackbar.show(dataObj);
        $('.mdc-linear-progress').fadeOut(500);
    });
}

function populateList(json) {
    var steps = json.length;
    for (i = 0; i < steps; i++) {
        var image = json[i]['image'][0];
        if (image == 'https://myanimelist.cdn-dena.com/images/anime//0.jpg') {
            image = '../images/unknown.png';
        } 
        $('#anime_list .mdc-list').append(
            '<li class="mdc-list-item anime_list_item" anime_id="' + json[i]['id'][0] + '">' + 
            '<img class="mdc-list-item__start-detail anime_list_thumb" data-src="' + image + '">' +
            '<span class="mdc-list-item__text anime_title">' + json[i]['title'][0] + 
            '<span class="mdc-list-item__text__secondary">' +
            '<i class="material-icons list-icon">star_rate</i>' + json[i]['user_score'][0] +
            '<i class="material-icons list-icon">playlist_add_check</i>' + json[i]['user_episodes'][0] + '/' + json[i]['episodes'][0] +
            '</span></span></li><hr class="mdc-list-divider">'
            );
        linearProgress.progress = (i + 1) / steps;
        $('#anime_list li[anime_id=' + json[i]['id'][0] +']').bind('click', function() {
            fetchAnime($(this).attr('anime_id'));
        });
    }
}

function clearDialog() {
    //Clear previous data
    $('#anime_title_info').css('background', 'var(--mdc-theme-primary)');
    $('#anilist_banner').attr('src', '');
    $('#hashtag').text('');
    $('#next_episode').css('display', 'none');
    $('#anilist_link_button').css('display', 'none');
    $('#anilist_link_button').attr('href', '');    
    $('#poster_background img').attr('src', '');
}

function populateDialog(json) {
    var steps = 14;

    //Fetch AniList Data
    $.when(fetchAniListData(json['id'][0])).then(function() {
        linearProgress.progress = 1 / steps;
        fetchMalData(json, steps);
    });
}

function fetchMalData(json, steps) {
     //Image
    if (json['image'][0] == 'https://myanimelist.cdn-dena.com/images/anime//0.jpg') {
        $('#mal_poster').attr('src', '../images/unknown.png');
    } else {
        $('#mal_poster').attr('src', json['image'][0]);        
    }
    $('#poster_background img').attr('src', json['image'][0]);
    linearProgress.progress = 2 / steps;

    //Title
    $('#info-dialog .mdc-dialog__header__title').text(json['title'][0]);
    linearProgress.progress = 3 / steps;

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
    linearProgress.progress = 4 / steps;

    //Episodes
    if (json['episodes'][0] == '0') {
        $('#info_dialog_episodes .mdc-list-item__text__secondary').text('TBA');
    } else {
        $('#info_dialog_episodes .mdc-list-item__text__secondary').text(json['episodes'][0]);
    }
    linearProgress.progress = 5 / steps;

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
    linearProgress.progress = 6 / steps;

    if (json['episodes'][0] == '1' || json['status'][0] != '2' || json['start_date'][0] == json['end_date'][0]) {
        $('#info_dialog_aired .mdc-list-item__text__secondary').text(formatDate(json['start_date'][0]));
    } else {
        $('#info_dialog_aired .mdc-list-item__text__secondary').text(
            formatDate(json['start_date'][0]) + ' to ' + formatDate(json['end_date'][0]));
    }
    linearProgress.progress = 7 / steps;

    //Premiered
    $('#info_dialog_premiered .mdc-list-item__text__secondary').text(getPremieredDate(json['start_date'][0]));
    linearProgress.progress = 8 / steps;

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
    linearProgress.progress = 9 / steps;

    //User Episodes
    $('#info_dialog_user_episodes .mdc-list-item__text__secondary').text(json['user_episodes'][0]);
    linearProgress.progress = 10 / steps;

    //User Score
    $('#info_dialog_user_score .mdc-list-item__text__secondary').text(json['user_score'][0]);
    linearProgress.progress = 11 / steps;

    //Start Date
    if (json['user_start_date'][0] == '0000-00-00') {
        $('#info_dialog_user_start_date .mdc-list-item__text__secondary').text('No date entered');
    } else {
        $('#info_dialog_user_start_date .mdc-list-item__text__secondary').text(formatDate(json['user_start_date'][0]));
    }
    linearProgress.progress = 12 / steps;

    //End Date
    if (json['user_end_date'][0] == '0000-00-00') {
        $('#info_dialog_user_end_date .mdc-list-item__text__secondary').text('No date entered');
    } else {
        $('#info_dialog_user_end_date .mdc-list-item__text__secondary').text(formatDate(json['user_end_date'][0]));
    }
    linearProgress.progress = 13 / steps;

    //MAL Link
    $('#mal_link_button').attr('href', 'https://myanimelist.net/anime/' + json['id'][0]);
    linearProgress.progress = 14 / steps;
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
    if (month == '01') {
        month = 'January';
    } else if (month == '02') {
        month = 'February';
    } else if (month == '03') {
        month = 'March';
    } else if (month == '04') {
        month = 'April';
    } else if (month == '05') {
        month = 'May';
    } else if (month == '06') {
        month = 'June';
    } else if (month == '07') {
        month = 'July';
    } else if (month == '08') {
        month = 'August';
    } else if (month == '09') {
        month = 'September';
    } else if (month == '10') {
        month = 'October';
    } else if (month == '11') {
        month = 'November';
    } else if (month == '12') {
        month = 'December';
    } else {
        month = '';
    }
    var formatted_date = '';
    if (year != '0000') {
        formatted_date = year;
    }
    if (month.length > 0) {
        if (day != '0') {
            formatted_date = month + ' ' + day + ', ' + year; 
        } else {
            formatted_date = month + ' ' + year;
        }
    }
    if (formatted_date.length == 0) {
        formatted_date = 'TBA';
    }
    return formatted_date;
}