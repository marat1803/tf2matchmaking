 $(document).ready(function(){
	$("#skill_from, #skill_to, #not_full").uniform();
	$(".small.button.bottom_nav").click(newLobby);
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

var maps = [
	'cp_well', 'cp_badlands', 'cp_granary', 'cp_freight'//etc
];//this will go in some other js file

function newLobby() {
	$popup = $('<div>').attr('id', 'popup');
	$form = $('<form>');
	
	$label = $('<label>').text('Name');
	$textbox = $('<input type="text" name="name">');
	$label.after($textbox);
	$form.append($label).append($textbox);

	$label = $('<label>').text('Server');
	$select = $('<select>').attr('name', 'server');
	$option = $('<option>').text("Auto");
	$option.val(0);
	$select.append($option);
	$option = $('<option>').text('My Own');//TODO: stuff
	$option.val(1);
	$select.append($option);
	$form.append($label).append($select); 

	$label = $('<label>').text('Type');
	$select = $('<select>').attr('name', 'type');
	$option = $('<option>').text('6vs6');
	$option.val(1);
	$select.append($option);
	$option = $('<option>').text('9vs9');
	$option.val(2);
	$select.append($option);
	$form.append($label).append($select); 

	$label = $('<label>').text('Map');
	$select = $('<select>').attr('name', 'map');
	for(key in maps) {
		$option = $('<option>').text(maps[key]);
		$option.val(maps[key]);
		$select.append($option);
	}
	$form.append($label).append($select);

	$submit = $('<input type="submit" class="button small" style="margin-top: 10px; margin-left: 115px;" value="Create!" />');
	$submit.click(addNewLobby);
	$form.append($submit);
	$popup.append($form);

	$popup.dialog({
		title: 'New Lobby',
		closeText: 'X',
		modal: true
		});
}

function joinGame(id) {
		$.ajax({
			data: {"id": id, "request": "joinGame"},
			url: 'api.php',
			dataType: 'json',
			success: function(data) {
				if (data != 0) window.location = "./lobby.php?id="+id;
				else alert('You are already in a lobby.');	
			}
		});
}

function addNewLobby() {
	$.ajax({
		url: 'api.php?request=newLobby',
		type:'post',
		data: {
			name: $('#popup input[name="name"]').val(),
			type: $('#popup select[name="type"]').val(),
			map:  $('#popup select[name="map"]').val()
		},
		success: function(data){
			if(data != 0) {
				window.location = "./lobby.php?id="+data;
			} else {
				alert('You can\'t create a new lobby');
			}
		}
	});
	return false;
}

