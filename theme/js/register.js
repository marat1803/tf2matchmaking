$(document).ready(function(){
	var nickname = $('input[name="nickname"]').val();
	var steamid = $('input[name="steamId64"]').val();
	var email = $('input[name="email"]').val();
	var loc = $('input[name="loc"]').val();
	register(nickname,steamid,email,loc);
});

function register(nickname,steamid,email,loc) {
	$('input.button.submit').click(function() {
		$.post("login.php", { "steamId64": steamid, "nickname": nickname, "email": email, "loc": loc },
		function(data){
			alert(data);
		});
	});
}