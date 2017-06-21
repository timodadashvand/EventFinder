$(document).ready(start);
function start(){
    $("#menuButton").on("click", showHideMenu);
	$("#navigation li").on("click", loadPage);
	loadStart();
	window.onresize = function() {
		if($(window).width() >= 500){
			$("#wrapper nav").slideDown(50);
		}
	}
}
function loadStart() {
	$("#loading").fadeIn(200);
	$.ajax({
		url:"start.html"
	}).done(function(data){
		$("#loading").fadeOut(200);
		$("#wrapper article").html(data);
	}).fail(function(){
		alert("Error!\n\nPage could not be loaded");
		$("#loading").fadeOut(200);
	});
}
function showHideMenu(){
    $("#wrapper nav").slideToggle(200);
}
function loadPage() {
	$("#loading").fadeIn(200);
	var page = $(this).attr("data-link");
	$.ajax({
		url:page, cache:false
	}).done(function(data){
		$("#loading").fadeOut(200);
		$("#wrapper article").html(data);
		if($(window).width() <= 500) {
			$("#wrapper nav").slideUp();
		}
	}).fail(function(){
		alert("Error!\n\nPage could not be loaded");
		$("#loading").fadeOut(200);
	});
}