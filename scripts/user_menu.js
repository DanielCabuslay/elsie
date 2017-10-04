var user_menu_element = document.querySelector('#user_menu');
var user_menu = new mdc.menu.MDCSimpleMenu(user_menu_element);
var user_menu_toggle = document.querySelector('#avatar');
user_menu_toggle.addEventListener('click', function() {
	user_menu.open = !user_menu.open;
});