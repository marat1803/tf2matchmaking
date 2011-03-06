		<div id="content" class="big_panel user_center">
			<ul class="nav_panel">
				<li><a href="index.html">Home</a></li>
				<li class="current"> &raquo; Admincenter</li>

			</ul>
			<div class="panel">
				<ul>
					<li>&raquo; Forum</li>
					<li><a href="#">&raquo; Adminlist</a></li>
					<li><a href="#">&raquo; Banlist</a></li>
				</ul>
			</div>
			<div class="panel" style="width: 700px">
				<h1>Topics:</h1>
					<table style="width: 100%;">
						<thead>
							<tr><td>&nbsp;</td><td>Name</td><td>Posts</td><td>Date</td></tr>	
						</thead>
						<tbody>
							<?php echo displayTopics(); ?>
						</tbody>
					</table>
					<div class="post_buttons">
						<a href="admin.php?page=forum&action=newTopic"  class="small button">New Topic</a>
					</div>
			</div>
		</div>
	</div>
</body>
</html>
