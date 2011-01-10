 $(document).ready(function(){
	$("#skill_from, #skill_to, #not_full").uniform();
	colapseLobbies();
});

function colapseLobbies() {
	$("li.lobby_tooltip").hide();
	(function($) {
    $("li.lobby_panel").click(function(){
        $('#'+$(this).attr('data-panel').replace('-', '\\:')).toggle();
    });
	})(jQuery);
}

