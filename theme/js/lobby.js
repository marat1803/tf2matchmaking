$(document).ready(function(){
	id = getQuerystring('id');
	refreshPage(id);
	refreshRate = 2000;
	refreshInterval = setInterval('refreshPage(id)', refreshRate);
	joinGame(id);
	leaveGame(id);
	changeReady(id);
	changeTeam(id);
	switchClass(id);
});

function refreshPage(id) {
	
	$.ajax({
		data: {"id": id, "request": "lobbyinfo"},
		url: 'api.php',
		dataType: 'json',
		success: function(data){
			$bluUl = $('ul.blue_players').empty().append('<li class="teamname blu">BLU</li>');
			$redUl = $('ul.red_players').empty().append('<li class="teamname red">RED</li>');
			for(var i=0;i<data.players.size;i++) {
				if(!data.players.blu[i]) {
					data.players.blu[i] = {
						id: 0,
						class: null,
						nickname: 'empty',
						avatar: null
					};
				}
				if (data.info.status == "ready") {
					if (data.players.blu[i].ready == 0) $li  = $('<li class="not_ready">');
					if (data.players.blu[i].ready == 1) $li  = $('<li class="ready">');
					if (data.info.leader == data.players.blu[i].id) $li = $('<li class="lobby_leader">');
				} else {
					if (data.info.leader == data.players.blu[i].id) $li = $('<li class="lobby_leader">');
					else $li  = $('<li>');
				}
				$a   = $('<a>');
				$class = $('<img>');

				$a.attr('href', 'profile.php?id=' + data.players.blu[i].id);
				$class.attr('src', 'theme/images/class/' + (data.players.blu[i].class ? data.players.blu[i].class : 'noclass') + '.png');
				$a.append($class).append(data.players.blu[i].nickname);
				if(data.players.blu[i].avatar) {
					$avatar = $('<img>').addClass('avatar');
					$avatar.attr('src', (data.players.blu[i].avatar ? data.players.blu[i].avatar : ''));
					$a.append($avatar);
				}
				$li.append($a);
				$bluUl.append($li);
			}

			for(var i=0;i<data.players.size;i++) {
				if(!data.players.red[i]) {
					data.players.red[i] = {
						id: 0,
						class: null,
						nickname: 'empty',
						avatar: null
					};
				}

				if (data.info.status == "ready") {
					if (data.players.red[i].ready == 0) $li  = $('<li class="not_ready">');
					if (data.players.red[i].ready == 1) $li  = $('<li class="ready">');
					if (data.info.leader == data.players.red[i].id) $li = $('<li class="lobby_leader">');
				} else {
					if (data.info.leader == data.players.red[i].id) $li = $('<li class="lobby_leader">');
					else $li  = $('<li>');
				}
				$a   = $('<a>');
				$class = $('<img>');

				$a.attr('href', 'profile.php?id=' + data.players.red[i].id);
				$class.attr('src', 'theme/images/class/' + (data.players.red[i].class ? data.players.red[i].class : 'noclass') + '.png');
				$a.append($class).append(data.players.red[i].nickname);
				if(data.players.red[i].avatar) {
					$avatar = $('<img>').addClass('avatar');
					$avatar.attr('src', (data.players.red[i].avatar ? data.players.red[i].avatar : ''));
					$a.append($avatar);
				}
				$li.append($a);
				$redUl.append($li);
			}

			spectators = [];
			for (var i=0;i<data.players.spec.length;i++) {
				if (!data.players.spec[i]) {
					delete data.players.spec[i];
					i--;
					continue;
				}
				spectators.push(data.players.spec[i].nickname);
			}
			$('ul.spec_players').text(spectators.join(', '));

			if (data.info.status == "ingame") {
				location.reload();
			}

			$("li.button.join_this")
				.add($("li.button.ready_up"))
				.add($("li.button.join_game"))
				.add($("li.button.ready_off"))
					.hide();

			if (data.inlobby == null) {
				$("li.button.join_this").show();
			} else if (data.ready == 1) {
				$("li.button.join_this")
					.add($("li.button.ready_up"))
					.add($("li.button.join_game"))
						.hide();
				$("li.button.ready_off").show();

				if (data.info.leader == data.id) {
					$("li.button.join_game").show();
					$("li.button.ready_off").hide();
				} else {
					$("li.button.join_game").hide();
				}

			} else {
				$("li.button.join_this").hide();
				$("li.button.ready_up").show();
				$("li.button.ready_off")
					.add($("li.button.join_game"))
						.hide();
				
			}

			if (data.count == 2 * data.players.size && data.players.spec.length == 0) {
				$('li.button.join_game').removeClass('locked');
				$('li.button.join_game').click(function(){
					$.ajax({
						data: {"id": id, "request": "startGame", "method": "write"},
						url: 'api.php',
						dataType: 'json',
					});					
				});
			} else {
				$('li.button.join_game').addClass('locked');
			}
		}
	});
}


function joinGame(id) {
	$("li.button.join_this").click(function() {
		$("li.button.join_this").addClass('locked');
		$.ajax({
			data: {"id": id, "request": "joinGame"},
			url: 'api.php',
			dataType: 'json',
			success: function() {
				refreshPage(id);
				
			}
		});
	});
}

function leaveGame(id) {
	$("div.button.small.exit_lobby").click(function() {
		$.ajax({
			data: {"id": id, "request": "leaveLobby"},
			url: 'api.php',
			dataType: 'json',
			success: function() {
				window.location = "./index.php";
			}
		});
	});
}

function changeReady(id) {
	$('li.button.ready_off').click(function(){
		$.ajax({
			data: {"id": id, "request": "readystatus", "ready": "0"},
			url: 'api.php',
			dataType: 'json',
			success: function() {
				refreshPage(id);
			}
		});
	});
	$('li.button.ready_up').click(function(){
		$.ajax({
			data: {"id": id, "request": "readystatus", "ready": "1"},
			url: 'api.php',
			dataType: 'json',
			success: function () {
				refreshPage(id);
			}
		});
	});
}

function changeTeam(id) {
	$('body').delegate('span.join_blu, li.teamname.blu', 'click', function(){
		$.ajax({
			data: {"id": id, "request": "changeTeam", "team": "1"},
			url: 'api.php',
			dataType: 'json',
			success: function() {
				refreshPage(id);
			}
		});
	});
	$('span.join_spec').click(function(){
		$.ajax({
			data: {"id": id, "request": "changeTeam", "team": "0"},
			url: 'api.php',
			dataType: 'json',
			success: function() {
				refreshPage(id);
			}
		});
	});
	$('body').delegate('span.join_red, li.teamname.red', 'click', function(){
		$.ajax({
			data: {"id": id, "request": "changeTeam", "team": "2"},
			url: 'api.php',
			dataType: 'json',
			success: function() {
				refreshPage(id);
			}
		});
	});
}

function switchClass (id) {
	$('li.scout').click(function(){
		$.ajax({
			data: {"id": id, "request": "switchClass", "class": "1"},
			url: 'api.php',
			dataType: 'json',
		});
	});
	$('li.soldier').click(function(){
		$.ajax({
			data: {"id": id, "request": "switchClass", "class": "2"},
			url: 'api.php',
			dataType: 'json',
		});
	});
	$('li.pyro').click(function(){
		$.ajax({
			data: {"id": id, "request": "switchClass", "class": "3"},
			url: 'api.php',
			dataType: 'json',
		});
	});
	$('li.demoman').click(function(){
		$.ajax({
			data: {"id": id, "request": "switchClass", "class": "4"},
			url: 'api.php',
			dataType: 'json',
		});
	});
	$('li.heavy').click(function(){
		$.ajax({
			data: {"id": id, "request": "switchClass", "class": "5"},
			url: 'api.php',
			dataType: 'json',
		});
	});
	$('li.engineer').click(function(){
		$.ajax({
			data: {"id": id, "request": "switchClass", "class": "6"},
			url: 'api.php',
			dataType: 'json',
		});
	});
	$('li.medic').click(function(){
		$.ajax({
			data: {"id": id, "request": "switchClass", "class": "7"},
			url: 'api.php',
			dataType: 'json',
		});
	});
	$('li.sniper').click(function(){
		$.ajax({
			data: {"id": id, "request": "switchClass", "class": "8"},
			url: 'api.php',
			dataType: 'json',
		});
	});
	$('li.spy').click(function(){
		$.ajax({
			data: {"id": id, "request": "switchClass", "class": "9"},
			url: 'api.php',
			dataType: 'json',
		});
	});	
	$('li.random').click(function(){
		$.ajax({
			data: {"id": id, "request": "switchClass", "class": "0"},
			url: 'api.php',
			dataType: 'json',
		});
	});
	id = getQuerystring('id');
	refreshPage(id);
}

function getQuerystring(key, default_)
{
  if (default_==null) default_=""; 
  key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regex = new RegExp("[\\?&]"+key+"=([^&#]*)");
  var qs = regex.exec(window.location.href);
  if(qs == null)
    return default_;
  else
    return qs[1];
}