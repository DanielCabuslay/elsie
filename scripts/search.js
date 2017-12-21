$(window).resize(function() {
    closeSearch();
    if ($(window).width() >= 1024) {
        $('.mdc-toolbar__section--align-start, .mdc-toolbar__section--align-end').css('display', 'inline-flex');
    }
});

$('#search_button').click(function() {
    $('#search_section').css('display', 'inline-flex'); 
    $('#search_query').focus();   
});

$('#search_query').focus(function() {
    openSearch();
});

$('#search_close, #search_sheet, #search_background').click(function() {
    closeSearch();
});

function openSearch() {
    $('html').css('overflow-y', 'hidden');
    $('#search_background').fadeIn('fast');
    $('#search_close').css('display', 'block');
    $('#search_section').css('background-color', 'white');
    $('.mdc-toolbar__section--align-start, .mdc-toolbar__section--align-end').css('visibility', 'hidden');
    $('#search_section i').css('color', 'var(--mdc-theme-text-primary-on-primary-light)');
    if ($(window).width() < 1024) {
        $('.mdc-toolbar__section--align-start, .mdc-toolbar__section--align-end').css('display', 'none');
    }
}

function closeSearch() {
    $('html').css('overflow-y', 'inherit');
    $('.mdc-toolbar #search_section').css('background-color', 'rgba(0,0,0,.2)');
    $('.mdc-toolbar__section--align-start, .mdc-toolbar__section--align-end').css('visibility', 'visible');
    $('#search_section i').css('color', 'var(--mdc-theme-text-primary-on-primary)');
    $('#search_section, #search_close').css('display', 'none');
    $('#search_sheet').css('top', '-100%');
    $('#search_header').fadeOut('fast');
    $('#search_query').val('');
    $('#search_results_list').empty();
    $('#search_background').fadeOut('fast');
    if ($(window).width() < 1024) {
        $('.mdc-toolbar__section--align-start, .mdc-toolbar__section--align-end').css('display', 'inline-flex');
    }    
}

var request;
$("#mal_search").submit(function(event) {
    linearProgress.determinate = false;
    $('.mdc-linear-progress').css('display', 'block');
    event.preventDefault();
    var $form = $(this);
    var $inputs = $form.find("input, button");
    var serializedData = $form.serialize();
    $inputs.prop("disabled", true);
    request = $.ajax({
        url: "search_list.php",
        type: "post", 
        data: serializedData,
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR){
        $('#search_results_list').empty();
        $.when(populateSearchResults(response)).then(function() {
            $('#search_sheet').css('top', '0');
            $('.mdc-linear-progress').fadeOut(500);
            $inputs.prop("disabled", false);
        });
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(errorThrown);
    });
});

function populateSearchResults(json) {
    var steps = json.length;
    if (steps > 0) {
        for (i = 0; i < steps; i++) {
            var image = json[i]['image'][0];
            if (image == 'https://myanimelist.cdn-dena.com/images/anime//0.jpg') {
                image = '../images/unknown.png';
            } 
            $('#search_results_list').append(
                '<li class="mdc-list-item anime_list_item" anime_id="' + json[i]['id'][0] + '">' + 
                '<img class="mdc-list-item__start-detail anime_list_thumb" src="' + image + '">' +
                '<span class="mdc-list-item__text anime_title">' + json[i]['title'][0] + 
                '<span class="mdc-list-item__text__secondary">' +
                '<i class="material-icons list-icon">star_rate</i>' + json[i]['user_score'][0] +
                '<i class="material-icons list-icon">playlist_add_check</i>' + json[i]['user_episodes'][0] + '/' + json[i]['episodes'][0] +
                '</span></span></li><hr class="mdc-list-divider">'
                );
            linearProgress.progress = (i + 1) / steps;
            $('#search_results_list li[anime_id=' + json[i]['id'][0] +']').bind('click', function() {
                fetchAnime($(this).attr('anime_id'));
            });
        }
    } else {
        $('#search_results_list').append(
            '<li class="mdc-list-item anime_list_item">' + 
            '<span class="mdc-list-item__text anime_title" style="margin: auto">No results found' + 
            '</span></li>'
            );

    }
}