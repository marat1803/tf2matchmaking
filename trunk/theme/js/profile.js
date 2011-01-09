$(document).ready(function(){
	id = getQuerystring('id');
	addFriend(id);
});

function addFriend(id) {
	$('div.friend_add.button').click(function(){
		$.get("api.php", {"fid": id, "request": "addFriend"}, function(data){
   		alert(data);
 	});
 })
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