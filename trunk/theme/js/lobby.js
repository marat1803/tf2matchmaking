$(document).ready(function(){
	refreshRate = 5000;
	refreshInterval = setInterval('refreshUsers()', refreshRate);
});

function refreshUsers() {
	
	$.ajax({
		data: {"id": 1, "request": "lobbydata"},
		url: 'api.php',
		success: function(data){
			result = JSON.parse(data);
			$bluUl = $('ul.blue_players').empty().append('<li class="teamname blu">BLU</li>');
			$redUl = $('ul.red_players').empty().append('<li class="teamname red">RED</li>');

			for(var i=0;i<result.size;i++) {
				if(!result.blu[i]) {
					result.blu[i] = {
						id: 0,
						class: null,
						nickname: 'empty',
						avatar: null
					};
				}

				$li  = $('<li>');
				$a   = $('<a>');
				$class = $('<img>');

				$a.attr('href', 'profile.php?id=' + result.blu[i].id);
				$class.attr('src', 'theme/images/class/' + (result.blu[i].class ? result.blu[i].class : 'noclass') + '.png');
				$a.append($class).append(result.blu[i].nickname);
				if(result.blu[i].avatar) {
					$avatar = $('<img>').addClass('avatar');
					$avatar.attr('src', (result.blu[i].avatar ? result.blu[i].avatar : ''));
					$a.append($avatar);
				}
				$li.append($a);
				$bluUl.append($li);
			}

			for(var i=0;i<result.size;i++) {
				if(!result.red[i]) {
					result.red[i] = {
						id: 0,
						class: null,
						nickname: 'empty',
						avatar: null
					};
				}

				$li  = $('<li>');
				$a   = $('<a>');
				$class = $('<img>');

				$a.attr('href', 'profile.php?id=' + result.red[i].id);
				$class.attr('src', 'theme/images/class/' + (result.red[i].class ? result.red[i].class : 'noclass') + '.png');
				$a.append($class).append(result.red[i].nickname);
				if(result.red[i].avatar) {
					$avatar = $('<img>').addClass('avatar');
					$avatar.attr('src', (result.red[i].avatar ? result.red[i].avatar : ''));
					$a.append($avatar);
				}
				$li.append($a);
				$redUl.append($li);
			}

		}
	});




}