$(function() {
	estilo();
	menu();
});

function estilo(){
	$("input[type='submit']").button();
	$(".logout").button({icons: { primary: "ui-icon ui-icon-power" }});
	$(".login").button({icons: { primary: "ui-icon ui-icon-locked" }});
}
function menu(){
	$("#menu_app").menu();
}