<?php
//
include 'library.auto-posting.php';

$username = 'philgo@gmail.com';
$password = 'asdf99**';


$site = urlencode('소너브 - 필리핀 커뮤니티');
$site_url_prefix = 'https://www.sonub.com/view/';
$posting_id = 'sonub';


$post = philgo_get_a_post( $posting_id );



if ( $post ) {
	$re = publish_post( $post );
	if ( $re['code'] == 0 ) {
		$url = $site_url_prefix . $re['data'];
		$result = 'SUCCESS';
	}
	else {
		$url = '';
		$result = "ERROR";
	}
	philgo_leave_log( $post, $result, $site, $url );
}



function publish_post( $post ) {

	$params = [
		'route'=>'post.create',
		'category' => 'discussion',
		'post_title' => $post['title'],
		'post_content' => $post['content'],
		'post_author_name' => 'philgo',
		'post_password' => 'tue11:55pm',
	];

	$query = http_build_query($params);




	$url = "https://www.sonub.com/wp-json/xapi/v2/do?$query";

//	print_r("url: $url");

	$re = get_json($url);

	return $re;

}