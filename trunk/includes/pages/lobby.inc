<ul id="sidebar">
			<li class="button join_this">Join!</li>
			<li class="button ready_up">Ready Up!</li>
			<li class="button ready_off">Unready!</li>
			<li class="button join_game">Start Game!</li>
			<li id="lobby_info">
				<?php echo $server->showServer($sid).$mumble->showServer($mid); ?>
			</li>
			<li class="profile_panel">
			<?php echo $user->display_profile($uid); ?>
			<h1 style="margin-top: 10px;">Settings</h1>
				<ul class="class_list">
		            <li class="scout"><img src="theme/images/class/scout.png" /></li>
		            <li class="soldier"><img src="theme/images/class/soldier.png" /></li>
		            <li class="pyro"><img src="theme/images/class/pyro.png" /></li>
		            <li class="demoman selected"><img src="theme/images/class/demo.png" /></li>
		            <li class="heavy"><img src="theme/images/class/heavy.png" /></li>
		            <li class="engineer"><img src="theme/images/class/engineer.png" /></li>
		            <li class="medic"><img src="theme/images/class/medic.png" /></li>
		            <li class="sniper"><img src="theme/images/class/sniper.png" /></li>
		            <li class="spy"><img src="theme/images/class/spy.png" /></li>
		            <li class="random"><img src="theme/images/class/noclass.png" /></li>
         		</ul>
				<span class="team_switch">
					<span class="join_blu"></span>
					<span class="join_spec"></span>
					<span class="join_red"></span>
				</span>
			</li>
			<li class="friends_panel">
				<h1>Friends</h1>
				<ul><?php echo getfriends($pid,true); ?>
				</ul>
			</li>
		</ul>
		<div id="content">
			<ul id="lobby_list">
			<?php displaylobby($lid,true,$ready); ?>
		<div class="chat_container">
			<h1>Chat</h1>
			<div id="chat_box">
				 <dl>
				 </dl>
			</div>
			<input id="chat_new" name="chat_new"><div class="button small chat_send" onclick="newChatMessage(<?php echo $lobby->id ?>)">Send</div>
		</div>
		<div class="button small exit_lobby">
			&laquo; Exit 
		</div>
	</div>
		</div>
</body>
</html>