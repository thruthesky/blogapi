<?php
//
/**
 *
 * $username, $password, $endpoint, $title, $content 에 정보가 들어오면 글을 포스팅 한다.
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
			"description" => new Value($content, 'string'),
			"title" => new Value($title, 'string'),
			"dateCreated" => new Value($date)
		], "struct"),
		new Value( 1, 'boolean' )
	)
);

$response = $client->send( $request );

if ( $response->faultCode() ) {
	echo json_encode( ['code' => $response->faultCode(), 'message' => $response->faultString()]);
}
else {
//	echo json_encode( ['code' => 0 ] );
	return 0;
}


