$(document).ready(function(){
	var nickname = $('input[name="nickname"]').val();
	var steamid = $('input[name="steamId64"]').val();
	var email = $('input[name="email"]').val();
	var loc = $('input[name="loc"]').val();
	register(nickname,steamid,email,loc);
});

function register(nickname,steamid,email,loc) {
	$('input.button.submit').click(function() {
		alert(nickname, steamid, email, loc);return false;
		$.ajax({
			url:"login.php",
			type:'post',
			data: {
				steamId64: steamid,
				nickname: nickname,
				email: email,
				loc: loc
			},
			success: function(data){
				alert(data);
			}
			return false;
		});
		return false;
	});
}