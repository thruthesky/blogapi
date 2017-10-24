<?php
//
$username = 'ionickorea';
$password = 'cea8149e81eeaebb8c438af05288e53e';
$endpoint = 'https://api.blog.naver.com/xmlrpc';

// 필고로 부터 글 하나 가져오기
$url = "http://www.philgo.com/?module=post&action=get_auto_poster_idx_submit&post_id=auto_posting&posting_id=naver-blog-ionickorea";
$post = get_json( $url );
if ( ! $post ) return;



// 필고로 부터 가져 온 글을 다듬는다.
$title = $post['subject'];
$content = $post['content'];
$content .= "<br> <p><a href='https://www.philgo.com/?$post[idx]'>#필고</a>
	<a href='https://www.philgo.com/?$post[idx]'>#마닐라</a>
	<a href='https://www.philgo.com/?$post[idx]'>#세부</a>
	<a href='https://www.philgo.com/?$post[idx]'>#앙헬레스</a>
	<a href='https://www.philgo.com/?$post[idx]'>#필리핀여행</a></p>";

$copyright = "<div><a href='https://www.philgo.com/'>필리핀 사이트 - 필고</a></div>&nbsp;<br>";
$content = "<div style='font-size: 14pt; line-height: 160%;'>$copyright$content</div>";


// Meta Weblog API 로 글을 쓴다
$re = include 'library.metaWeblog.newPost.php';


// 결과를 해당 글에 저장한다.
if ( is_numeric($re) ) {
	$re = "http://blog.naver.com/PostView.nhn?blogId=ionickorea&logNo=" . $re;
}
else {
	$re = "ERROR: $re";
}
$re = urlencode($re);
$url = "http://www.philgo.com/?module=post&action=auto_posting_log&submit=1&idx=$post[idx]&site=naver&re=$re";

$re = get_json($url);
if ( ! $re ) {
//	echo "ERROR saving log\n";
}
else {
//	echo "SUCCESS: \n";
//	print_r( json_decode($re, true));
}

/**
 * URL 을 입력 받아서, 그 URL 의 데이터를 추출 한 다음 JSON 으로 리턴한다.
 *
 * @param $url
 *
 * @return mixed|null
 *  null if error
 */
function get_json( $url ) {
	$body = file_get_contents($url);
//	print_r($body);
	if ( empty($body) ) return null;
	$arr = json_decode($body, true);
	$error = json_last_error();
	if ( $error ) return null;
	return $arr;
}

