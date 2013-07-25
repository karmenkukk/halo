<?php

class admin {
	public $requires_auth = true;
	function index(){
		global $request;
		require 'classes/tag.php';
		require 'classes/post.php';
		$param = $request->get[0];
		if ($param == 'delete'){
			post::delete($request->get[1]);
		}

		$posts = get_all("SELECT *, count(comment_id) AS comment_count FROM post NATURAL JOIN user NATURAL JOIN comment GROUP BY post_id");
		$tags = tag::get_tags();

		require 'views/master_view.php';
	}
	function edit_post(){
		global $request;
		require 'classes/post.php';
		if (!empty($request->post['post_text'])){
				post::edit($request->get[0]);
		}
		$id = $request->get[0];
		$post = get_first("SELECT * FROM post WHERE post_id='$id'");
		$comments = get_all("SELECT comment_id, comment_text, comment_author, comment_time
		                     FROM comment
		                     WHERE post_id='$id'");
		require 'views/master_view.php';
	}
}