<?php
//

// Meta Weblog API 로 글을 쓴다
/**
 *
 * $username, $password, $endpoint, $post[title], $post[content] 에 정보가 들어오면 글을 포스팅 한다.
 */

require_once 'src/Autoloader.php';
\PhpXmlRpc\Autoloader::register();
use PhpXmlRpc\Value;
use PhpXmlRpc\Request;
use PhpXmlRpc\Client;


$date = PhpXmlRpc\Helper\Date::iso8601Encode(time());

$client = new Client( $endpoint );
$request = new Request('metaWeblog.newPost',
	array(
		new Value( md5('key') , "string"),
		new Value( $username , "string"),
		new Value( $password , "string"),
		new Value( [
//			"categories" => new Value([ new Value('필리핀 스토리', 'string')], 'struct'),
			"description" => new Value($post['content'], 'string'),
			"title" => new Value($post['title'], 'string'),
			"dateCreated" => new Value($date)
		], "struct"),
		new Value( 1, 'boolean' )
	)
);

$response = $client->send( $request );

if ( $response->faultCode() ) {
//	echo json_encode( ['code' => $response->faultCode(), 'message' => $response->faultString()]);
	$ret = "code: " . $response->faultCode() . ", message: " . $response->faultString();
}
else {
//	echo json_encode( ['code' => 0 ] );


//	echo "Success\n";
//	print_r($response->val); // Response 클래스의 바로 아래에 Value 클래스 객체가 들어가 있다.
//	foreach ( $response->val as $valueArrays ) {
//		foreach ( $valueArrays as $values ) {
//			foreach ( $values as $value ) {
//				print_r( $value . "\n" );
//			}
//		}
//	}

	$ret = $response->val->me['string'];



//	return 0;
}


return $ret;
