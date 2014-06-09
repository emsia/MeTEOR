var theScroll;

function scroll(){
    theScroll = new iScroll('wrapper');
}

document.addEventListener('DOMContentLoaded', scroll, false);

function page(toPage) {
    var toPage = $(toPage),
    fromPage = $("#pages .current");
    if(toPage.hasClass("current") || toPage === fromPage) {
        return;
    };
    toPage.addClass("current fade in").one("webkitAnimationEnd", function(){
        fromPage.removeClass("current fade out");
        toPage.removeClass("fade in")
    });
    fromPage.addClass("fade out");
}

function getTweets() {
    var q = "ufo+spotted"
        rpp = 5,
        twurl = "http://search.twitter.com/search.json?q=";
    $.getJSON(twurl + q + "&rpp=" + rpp + "&callback=?", function(data){
			        $("#tmpl-tweets").tmpl(data.results).appendTo("#tweets");
			    });
}

$(document).ready(function(){
	$('#tab-bar a').click( function(e){
		e.preventDefault();
		var nextPage = $(e.target.hash);
		$("#pages .current").fadeOut('slow', function() {});
		nextPage.fadeIn('slow', function() {});
		nextPage.addClass("current");			
		getTweets();
	});
});