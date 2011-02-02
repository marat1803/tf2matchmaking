<?php

require_once 'includes/header.php';

$id = $_GET['id'];
if (!$id) $id = $_SESSION['id'];
if (!$id) header('Location: index.php');

$user = new User($id);


$css = 'style_profile.css';
$js = 'profile.js';

include_once 'includes/header.inc';

echo '
        <div id="content" class="big_panel">
            <ul class="nav_panel">
                <li><a href="index.php">Home</a></li>
                <li class="current"> &raquo; Profile</li>
                <li><a href="usercenter.php"> &raquo; Control Center</a></li>
            </ul>
            <div class="avatar_panel">
                <img class="avatar_big" src="'.APIGet($user->steamid,avatar).'">';
                if ($id != $_SESSION['id']) echo'
                <div class="friend_add button">+ Add</div>';
            echo '</div>
            '.$user->display_profile($id, false).'
            <ul class="recentlobby_panel">
                <li><span>Powerlobby<small style="float: right;">6 vs. 6</small></span><img class="map_pic" src="theme/images/maps/cp_granary.jpg"></li>
                <li><span>Superlobby<small style="float: right;">6 vs. 6</small></span><img class="map_pic" src="theme/images/maps/cp_granary.jpg"></li>
                <li><span>Staubsaugerlobby<small style="float: right;">6 vs. 6</small></span><img class="map_pic" src="theme/images/maps/cp_badlands.jpg"></li>
                <li><span>Freibier<small style="float: right;">6 vs. 6</small></span><img class="map_pic" src="theme/images/maps/cp_dustbowl.jpg"></li>
            </ul>
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
            <div class="team_panel">
                <h1>Team</h1>
                <ul>
                    <li>
                        <img src="http://media.steampowered.com/steamcommunity/public/images/avatars/4b/4be5d08ac4dde632773f3b9f28663cae74d02169.jpg">
                        <span class="user_name">The Good Guys!</span>
                        <span class="user_steamid"><a href="http://good.hobbygaming.de/">good.hobbygaming.de</a></span>
                    </li>
                </ul>
            </div>
    </div>
</body>
</html>';


    
?>