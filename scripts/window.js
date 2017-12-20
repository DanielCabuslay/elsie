const snackbar = new mdc.snackbar.MDCSnackbar(document.querySelector('.mdc-snackbar'));
const determinate = document.querySelector('.mdc-linear-progress');
const linearProgress = mdc.linearProgress.MDCLinearProgress.attachTo(determinate);

$(document).ready(function() {
  if ($(window).width() < 1024) {
    $('#search_section').css('display', 'none');
  }
  linearProgress.determinate = true;
  linearProgress.progress = 0;
  $('.mdc-linear-progress').fadeIn(100);
  window.navBar = new mdc.tabs.MDCTabBar(document.querySelector('.mdc-tab-bar')); 
  $.when(fetchList(1)).then(function() {
    $('.toolbar_title .mdc-typography--caption').text('Watching');
  });
});

$('#anime_list_nav a').click(function() {
  var clicked_section = $(this).attr('id');
  if (clicked_section == 'watching_button') {
    fetchList(1);
    $('.toolbar_title .mdc-typography--caption').text('Watching');    
  } 
  else if (clicked_section == 'completed_button') {
    fetchList(2);
    $('.toolbar_title .mdc-typography--caption').text('Completed');   
  } 
  else if (clicked_section == 'on_hold_button') {
    fetchList(3);
    $('.toolbar_title .mdc-typography--caption').text('On Hold');
  }
  else if (clicked_section == 'dropped_button') {
    fetchList(4);
    $('.toolbar_title .mdc-typography--caption').text('Dropped');
  }
  else if (clicked_section == 'ptw_button') {
    fetchList(6);
    $('.toolbar_title .mdc-typography--caption').text('Plan to Watch');
  }
  window.scrollTo(0, 0);
});
