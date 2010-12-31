<?php

require_once 'includes/header.php';

$id = $_GET['id'];
$steamid = User::get_steamid($id);

$user = new User($id);

$css = 'style_profile.css';

include_once 'includes/header.inc';

echo '
        <div id="content" class="big_panel">
            <ul class="nav_panel">
                <li><a href="index.php">Home</a></li>
                <li class="current"> &raquo; Profile (far from being finished, but at least some progress)</li>
            </ul>
            <div class="avatar_panel">
                <img class="avatar_big" src="'.APIGet($steamid,avatar).'">';
if($steamid != $_SESSION['steamid']) {
    echo '<a href="addfriend.php?id='.$id.'" class="friend_add button">+ Add</a>';
}
            echo '</div>
            '.$user->display_profile($id, false).'
            <dl class="stats_panel">
                <dt>Wins</dt><dd>7</dd>
                <dt>Losses</dt><dd>10</dd>
                <dt>Ratio</dt><dd>0.7</dd>
            </dl>
            <div class="friends_panel">
                <h1>Friends</h1>
                <ul>';
                echo getfriends($id).'
                </ul>
            </div>
    </div>
</body>
</html>';


    
?>