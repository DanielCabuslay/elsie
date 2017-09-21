$('.search_button').click(function() {
    $('#search_header').fadeIn('fast');
    $('.translucent').fadeIn('fast');
    $('#search_fab').fadeOut('fast');
    $('#search_query').focus();
    // $('html').css('overflow-y', 'hidden');
});
$('#search_close').click(function() {
    if ($(window).width() <= 768) {
        $('#search_fab').fadeIn('fast');            
    }
    $('#search_sheet').css('top', '-100%');
    $('#search_header').fadeOut('fast');
    $('#search_query').val('');
    $('#search_results_list').empty();
    $('.translucent').fadeOut('fast');
    // $('html').css('overflow-y', 'visible');
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
    }, 300);
});