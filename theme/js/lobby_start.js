id = getQuerystring('id');

$(function(){
	$('body').delegate('a.rate_up', 'click', function(){
		$a = $(this);
		$.ajax({
			url: 'api.php?request=rate',
			type: 'post',
			data: {
				lid: id,
				userid:  $(this).attr('data-id'),
				value: 1
			},
			success: function(){
				$a.addClass("active");
			}
		});

	});


	$('body').delegate('a.rate_down', 'click', function(){
		$a = $(this);
		$.ajax({
			url: 'api.php?request=rate',
			type: 'post',
			data: {
				lid: id,
				userid:  $(this).attr('data-id'),
				value: 0
			},
			success: function(){
				$a.addClass("active");

			}
		});

	});


});

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