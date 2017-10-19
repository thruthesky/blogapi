<?php

$username = 'ionickorea';
$password = 'cea8149e81eeaebb8c438af05288e53e';
$endpoint = 'https://api.blog.naver.com/xmlrpc';



$url = "http://www.philgo.com/?module=post&action=get_auto_poster_idx_submit&post_id=buyandsell&posting_id=naver-blog-ionickorea";
$body = file_get_contents($url);

if ( empty($body) ) return;

$post = get_json( $body );
if ( ! $post ) return;


$title = $post['subject'];
$content = $post['content'];
$content .= "<br> <p><a href='https://www.philg.com/?$post[idx]'>#필고</a>
	<a href='https://www.philg.com/?$post[idx]'>#마닐라</a>
	<a href='https://www.philg.com/?$post[idx]'>#세부</a>
	<a href='https://www.philg.com/?$post[idx]'>#앙헬레스</a>
	<a href='https://www.philg.com/?$post[idx]'>#필리핀여행</a></p>";

$content = "<div style='font-size: 14pt; line-height: 160%;'>$content</div>";



include 'library.metaWeblog.newPost.php';




function get_json( $body ) {

	$arr = json_decode($body, true);
	$error = json_last_error();
	if ( $error ) return null;
	return $arr;

}

