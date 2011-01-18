<?php 

require_once 'includes/header.php';

$db = Database::obtain();

if(isset($_POST['nickname'], $_POST['email'], $_POST['steamId64'])) {
	$nickname = substr($_POST['nickname'], 0, 80);
	$email = $_POST['email'];
	$steamid = (string)$_POST['steamId64'];
	$data = array('steamid'  => $steamid,
				  'nickname' => $nickname,
				  'email'	 => $email,
				  'country'	 => $_POST['loc']);
	$sql = $db->insert('users',$data);
	$data2['id'] = $sql;
	$sql2 = $db->insert('ratings',$data2);
	$_SESSION['id'] = User::get_id($steamid);
	echo 'Your account has been successfully created.';
	redirect('index.php',3);
} else {
	
echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>TF2 Matchmaking System</title>
	<link href="theme/style_profile.css" rel="stylesheet" type="text/css" />
	<link href="theme/uniform.default.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="background_image"></div>
	<div id="wrapper">
		<div id="header">
			<a href="" id="logo">TF2 Matchmaking System</a>
		</div>
		<div id="content" class="big_panel">
			<ul class="nav_panel">
				<li><a href="index.html">Home</a></li>
				<li class="current"> &raquo; Register</li>
			</ul>
		<h1 style="float: left; font-size: 3em; width: 90%; text-align: center; border-bottom: 1px solid; margin: 20px 5%; padding-bottom: 10px;">Welcome!</h1>
		<form method="post" action="" style="margin-top: 10px;">
		<input type="hidden" name="steamId64" value="' . $_SESSION['steamid'] . '">
			<p style="margin: 10px 50px;">Thank you for using TF2MM! Since this is the first time you\'re using TF2MM, we\'d like to know more about you.</p>
			<div class="panel" style="width: 500px; margin-left: 50px;">
				<label>Nickname:</label>
				<input type="text" value="' .APIGet($steamid,personaname). '" name="nickname"/><small style="float: left;margin: 3px;">(Cannot be blank)</small>
			</div>
			<input type="submit" style="float: right; width: 250px; margin-right:54px;  margin-bottom: 0;" value="Submit" class="button submit" />
			<div class="panel" style="width: 500px; margin-left: 50px;">
				<label>Email:</label>
				<input type="text" name="email"/><small style="float: left;margin: 3px;">(Can opt-out at any time)</small>
				<label>Country:</label>
				<input type="text" name="loc" value="'.APIGet($steamid,loccountrycode).'" />
			</div>
			<p style="float: right; width: 250px; margin-right:50px; margin-top: 0;">Entering this information is completely optional and not required, but will aid in better match making.</p>
		</form>
	</div>
	<script src="theme/js/jquery.js" type="text/javascript"></script>
	<script src="theme/js/jquery.uniform.min.js" type="text/javascript"></script>
	<script src="theme/js/register.js" type="text/javascript"></script>
</body>
</html>';
}
?>