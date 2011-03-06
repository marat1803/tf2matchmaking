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
				<h1>Topic:</h1>
					<?php echo displayPosts($_GET['topic']); ?>
					<div class="post_buttons">
						<a href="admin.php?page=forum&action=newPost&topic=<?php echo $_GET['topic']; ?>"  class="small button">Answer</a>
					</div>
			</div>
		</div>
	</div>
</body>
</html>
