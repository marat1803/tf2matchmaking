<ul id="sidebar">
			<a href="<?php echo $server->getUrl() ?>" class="button connect_server">Connect!</a> <!--If the user is in an other lobby, show him some kind of popup alert-->
			<!--<li class="button ready_up">Ready Up!</li>-->
			<!--<li class="button ready_off">Unready!</li>-->
			<!--<li class="button join_game">Start Game!</li> -->
			<li id="lobby_info">
				<?php echo $server->showServer($sid).$mumble->showServer($mid); ?>
			</li>
			<li class="profile_panel">
			<?php echo $user->display_profile($uid); ?>
				<h1 style="margin-top: 10px;">Options</h1>
				<div style="float:left; width: 100%; text-align: center;">
					<a href="#request_merc" class="small button">+ Merc</a> Request a substitute
				</div>
			</li>
			<li class="friends_panel">
				<h1>Friends</h1>
				<ul><?php echo getfriends($pid,true); ?>
				</ul>
			</li>
		</ul>
		<div id="content">
			<ul id="lobby_list">
				<?php displaylobby($lid,true,false,true); ?>
				</li>
			</ul>
			<div class="chat_container">
				<h1>Chat Log</h1>
				<div id="chat_box" style="height: auto;">
					 <dl>
					 	<dt class="lobby_log">Hobbybash0r</dt><dd>joined the lobby.<span class="time">14:01</span></dd>
					 	<dt>Hobbybash0r:</dt><dd>this is a fucking chat dummy message<span class="time">14:03</span></dd>
						<dt>Hobbybash0r</dt><dd>this is a fucking chat dummy message<span class="time">14:05</span></dd>
						<dt class="lobby_log">Nightbox</dt><dd>left the lobby.<span class="time">14:07</span></dd>
						<dt>Hobbybash0r</dt><dd>this is a fucking chat dummy message<span class="time">14:08</span></dd>
						<dt>Hobbybash0r</dt><dd>this is a fucking chat dummy message<span class="time">14:09</span></dd>
						<dt class="lobby_log">Hobbybash0r</dt><dd>was kicked by the lobby leader.<span class="time">14:10</span></dd>
					 </dl>
				</div>
			</div>
			<div class="button small bottom_nav">
				&laquo; Exit 
			</div>
		</div>
	</div>
</body>
</html>