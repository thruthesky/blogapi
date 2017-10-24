<?php

function philgo_get_a_post($posting_id) {
	// 필고로 부터 글 하나 가져오기
	$url = "http://www.philgo.com/?module=post&action=get_auto_poster_idx_submit&post_id=auto_posting&posting_id=$posting_id";
	$post = get_json( $url );

	if ( ! $post ) return null;

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


	return [ 'idx' => $post['idx'], 'title' => $title, 'content' => $content ];
}

function philgo_leave_log( $post, $result, $site, $url ) {


	$url = urlencode($url);
	$re = "$result||$url||" . date('Y-m-d H:i');
	$url = "http://www.philgo.com/?module=post&action=auto_posting_log&submit=1&idx=$post[idx]&site=$site&re=$re";

//	print_r("url: " . $url);
	$re = get_json($url);
	if ( ! $re ) {
//	echo "ERROR saving log\n";
	}
	else {
//	echo "SUCCESS: \n";
//	print_r( json_decode($re, true));
	}


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


