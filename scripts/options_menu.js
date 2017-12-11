var options_menu_element = document.querySelector('#options_menu');
var options_menu = new mdc.menu.MDCSimpleMenu(options_menu_element);
var options_menu_toggle = document.querySelector('#options_button');
options_menu_toggle.addEventListener('click', function() {
	options_menu.open = !options_menu.open;
});

var list_menu_element = document.querySelector('#list_menu');
var list_menu = new mdc.menu.MDCSimpleMenu(list_menu_element);
var list_menu_toggle = document.querySelector('#list_drop_down');
list_menu_toggle.addEventListener('click', function() {
	list_menu.open = !list_menu.open;
});