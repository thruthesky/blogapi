<?php
//
include 'library.auto-posting.php';

$username = 'ionickorea';
$password = 'cea8149e81eeaebb8c438af05288e53e';
$endpoint = 'https://api.blog.naver.com/xmlrpc';


$posting_id = 'naver-blog-ionickorea';
$posting_id = 'naver-blog-ionickorea2';

$post = philgo_get_a_post( $posting_id );
if ( $post ) {
	$re = include 'library.metaWeblog.newPost.php';
	if ( is_numeric($re) ) {
		$url = "http://blog.naver.com/PostView.nhn?blogId=ionickorea&logNo=" . $re;
		$result = 'SUCCESS';
	}
	else {
		$result = "ERROR";
	}
	philgo_leave_log( $post, $result, 'naver', $url );
}






