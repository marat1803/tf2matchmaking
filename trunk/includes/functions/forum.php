<?php

function newTopic($name,$poster,$message) {
	$db = Database::obtain();
	$data['name'] = $name;
	$data['lastpost'] = date('Y-m-d H:i:s');
	$topic = $db->insert('forum_topics',$data);
	newPost($topic,$poster,$message);
	return $topic;
}

function newPost($topic,$poster,$message) {
	$db = Database::obtain();
	$data['topic'] = $topic;
	$data['poster'] = $poster;
	$data['message'] = trim(strip_tags($message));
	$post = $db->insert('forum_posts',$data);
	$update['lastpost'] = date('Y-m-d H:i:s');
	$where = 'id = '.$db->escape($topic);
	$db->update('forum_topics',$update,$where);
	return $post;
}

function countPosts($topic) {
	$db = Database::obtain();
	$sql = 'SELECT COUNT(*) FROM forum_posts WHERE topic = '.$topic;
	$count = $db->query_first($sql);
	return $count['COUNT(*)'];
}

function displayTopics() {
	$db = Database::obtain();
	$sql = 'SELECT * FROM forum_topics ORDER BY lastpost DESC';
	$topics = $db->fetch_array($sql);
	$return = '';
	foreach($topics as $topic) {
		$return .= '<tr><td><img src="theme/images/bullet_green.png" /></td><td><a href="admin.php?page=forum&topic='.$topic['id'].'">'.$topic['name'].'</a></td><td>'.countPosts($topic['id']).'</td><td>'.ago(strtotime($topic['lastpost'])).'</td></tr>';
	}
	return $return;
}

function Topic($id) {
	$db = Database::obtain();
	$sql = 'SELECT * FROM forum_topics WHERE id = '.$db->escape($id);
	return $db->query_first($sql);
}

function displayPosts($topic) {
	$db = Database::obtain();
	$sql = 'SELECT * FROM forum_posts WHERE topic = '.$db->escape($topic).' ORDER by id ASC';
	$posts = $db->fetch_array($sql);
	$return = '';
	foreach ($posts as $post) {
		$author = player($post['poster']);
		$return .= '<div class="post">
						<div class="author">
						<a href="profile.php?id='.$author['id'].'">'.$author['nickname'].'<br /><img src="cache/avatars/'.$author['steamid'].'.jpg" width="50" height="50" /></a>
						</div>
						<div class="message">
							'.$post['message'].'
						</div>
					</div>';
	}
	return $return;
}

function newPosts() {
	$db = Database::obtain();
	$sql = 'SELECT nickname,topic,name,forum_topics.date FROM forum_posts 
			INNER JOIN users ON forum_posts.poster = users.id
			INNER JOIN forum_topics ON forum_posts.topic = forum_topics.id
			ORDER BY date DESC LIMIT 5';
	$posts = $db->fetch_array($sql);
	$return = '';
	foreach ($posts as $post) {
		$return = '<tr><td><img src="theme/images/bullet_green.png"></td><td><a href="admin.php?page=forum&topic='.$post['topic'].'">'.$post['name'].'</a></td><td>&nbsp;</td><td>'.$post['nickname'].'</td><td><img src="theme/images/time_red.png">'.ago($post['date']).'</td></tr>';
	}
	return $return;
}


?>