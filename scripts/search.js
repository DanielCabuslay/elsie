$('#search_button_menu').click(function() {
    $('#search_section').css('display', 'inline-flex'); 
    $('#search_query').focus();   
})
$('#search_query').focus(function() {
    $('html').css('overflow-y', 'hidden');
    $('#main_toolbar').addClass('opaque');
    $('#search_background').fadeIn('fast');
    $('#search_close').css('display', 'block');
    $('.mdc-toolbar #search_section').css('background-color', 'white');
    $('.mdc-toolbar__title').css('display', 'none');
    $('#search_section i').css('color', 'var(--mdc-theme-text-primary-on-primary-light)');
    if ($(window).width() < 1024) {
        $('.mdc-toolbar__section--align-start').css('display', 'none');
        $('.mdc-toolbar__section--align-end').css('display', 'none');
    }
});
$('#search_close').click(function() {
    $('html').css('overflow-y', 'inherit');
    $('#main_toolbar').removeClass('opaque');
    $('.mdc-toolbar #search_section').css('background-color', 'rgba(0,0,0,.2)');
    $('.mdc-toolbar__title').css('display', 'block');
    $('#search_section i').css('color', 'var(--mdc-theme-text-primary-on-primary)');
    if ($(window).width() < 1024) {
        $('.mdc-toolbar__section--align-start').css('display', 'inline-flex');
        $('.mdc-toolbar__section--align-end').css('display', 'inline-flex');
        $('#search_section').css('display', 'none'); 
    }
    $('#search_close').css('display', 'none');
    $('#search_sheet').css('top', '-100%');
    $('#search_header').fadeOut('fast');
    $('#search_query').val('');
    $('#search_results_list').empty();
    $('#search_background').fadeOut('fast');
});
function showResults() {
    if ($('#search_query').val().length == 0) {
        $('#search_sheet').css('top', '-100%');
    }
}

var request;
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
  clearTimeout (timer);
  timer = setTimeout(callback, ms);
 };
})();
$("#mal_search").keyup(function(event) {
    event.preventDefault();
    if (request) {
        request.abort();
    }
    var $form = $(this);
    var $inputs = $form.find("input, button");
    var serializedData = $form.serialize();
    // $inputs.prop("disabled", true);
    delay(function(){
        if ($('#search_query').val().length > 0) {
            request = $.ajax({
                url: "mal_search.php",
                type: "post",
                data: serializedData
            });
            request.done(function (response, textStatus, jqXHR){
                // Log a message to the console
                // console.log(response);
                $('#search_results ul').html(response);
                $('#search_sheet').css('top', '0');

                var request2;
                $('.search_result_item').click(function() {
                    var id = $(this).attr('anime_id');
                    var title = $(this).attr('anime_title');
                    request2 = $.ajax({
                        url: "anime_fetch_info.php",
                        type: "post",
                        data: {id: id, title: title}
                    });
                    request.done(function (response, textStatus, jqXHR){
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
                // console.log(textStatus);
            });
            request.fail(function (jqXHR, textStatus, errorThrown){
                // Log the error to the console
                console.error(
                    "The following error occurred: "+
                    textStatus, errorThrown
                );
            });
        }  
    }, 200);
});