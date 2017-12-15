const snackbar = new mdc.snackbar.MDCSnackbar(document.querySelector('.mdc-snackbar'));
const determinate = document.querySelector('.mdc-linear-progress');
const linearProgress = mdc.linearProgress.MDCLinearProgress.attachTo(determinate);
$(document).ready(function() {
  linearProgress.determinate = false;
  $('.mdc-linear-progress').css('display', 'block');
});

window.onload = function() {
  $('.loading_splash').remove();
  $(':root').css('--mdc-theme-primary', '#388e3c');
  $('meta[name=theme-color]').attr('content', '#388e3c');
  $('.toolbar_title .mdc-typography--caption').text('Watching');
  $('main').fadeIn(100);
  $('.mdc-linear-progress').removeClass('mdc-linear-progress--indeterminate');
  $('.mdc-linear-progress').delay(100).fadeOut(500);
  window.navBar = new mdc.tabs.MDCTabBar(document.querySelector('.bottom_bar_nav'));
};

$('#anime_list_nav a').click(function() {
  $('#anime_list section').fadeOut(100);
  var clicked_section = $(this).attr('id');
  if (clicked_section == 'watching_button') {
    $(':root').css('--mdc-theme-primary', '#388e3c');
    $('meta[name=theme-color]').attr('content', '#388e3c');
    $('#watching_list').delay(100).fadeIn(100);
    $('.toolbar_title .mdc-typography--caption').text('Watching');
  } 

  else if (clicked_section == 'completed_button') {
    $(':root').css('--mdc-theme-primary', '#1976d2');
    $('meta[name=theme-color]').attr('content', '#1976d2');
    $('#completed_list').delay(100).fadeIn(100);
    $('.toolbar_title .mdc-typography--caption').text('Completed');
  } 

  else if (clicked_section == 'on_hold_button') {
    $(':root').css('--mdc-theme-primary', '#f9a825');
    $('meta[name=theme-color]').attr('content', '#f9a825');
    $('#on_hold_list').delay(100).fadeIn(100);
    $('.toolbar_title .mdc-typography--caption').text('On Hold');
  }

  else if (clicked_section == 'dropped_button') {
    $(':root').css('--mdc-theme-primary', '#d32f2f');
    $('meta[name=theme-color]').attr('content', '#d32f2f');
    $('#dropped_list').delay(100).fadeIn(100);
    $('.toolbar_title .mdc-typography--caption').text('Dropped');
  }

  else if (clicked_section == 'ptw_button') {
    $(':root').css('--mdc-theme-primary', '#616161');
    $('meta[name=theme-color]').attr('content', '#616161');
    $('#ptw_list').delay(100).fadeIn(100);
    $('.toolbar_title .mdc-typography--caption').text('Plan to Watch');
  }
  window.scrollTo(0, 0);
});

(function() {
  setTimeout(function() {
    window.navBar = new mdc.tabs.MDCTabBar(document.querySelector('.bottom_bar_nav'));
  }, 200)
})();
