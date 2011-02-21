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
	$data['message'] = $message;
	$post = $db->insert('forum_posts',$data);
	$topic['lastpost'] = date('Y-m-d H:i:s');
	$where = 'id = '.$db->escape($topic);
	$db->update('forum_topics',$topic,$where);
	return $post;
}

function displayTopics() {
	$db = Database::obtain();
	$sql = 'SELECT * FROM forum_topics';
	$topics = $db->fetch_array($sql);
	$return = '';
	foreach($topics as $topic) {
		$return .= $topic['name'];
	}
	return $return;
}

function displayPosts($topic) {
	$db = Database::obtain();
	$sql = 'SELECT * FROM forum_posts WHERE topic = '.$db->escape($topic);
	$posts = $db->fetch_array($topic);
	$return = '';
	foreach ($posts as $post) {
		$return .= $post['message'];
	}
	return $return;
}


?>