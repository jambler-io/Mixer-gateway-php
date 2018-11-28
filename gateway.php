<?
$apiKey = '__YOUR_JAMBLER_API_KEY__';
$apiUrl = 'https://api.jambler.io';
$coinId = 'btc';

switch($_REQUEST['res']) {
	case 'info': info(); break;
	case 'mix': mix(); break;
	case 'guarantee': guarantee(); break;
}

function curlInit($method, $url) {
	global $apiKey;
	$headers = array(
		'Cache-Control: no-cache',
		'Content-Type: application/json',
		'xkey: '.$apiKey
	);
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_TIMEOUT => 10,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => $method
	));
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	return $curl;
}

function info() {
	global $apiUrl, $coinId;
	$curl = curlInit('GET', $apiUrl.'/partners/info/'.$coinId);
	$res = json_decode(curl_exec($curl), true);
	curl_close($curl);
	echo json_encode($res);
}

function mix() {
	global $apiUrl, $coinId;
	$curl = curlInit('POST', $apiUrl.'/partners/orders/'.$coinId);
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
		'forward_addr' => $_REQUEST['forward_addr'],
		'forward_addr2' => $_REQUEST['forward_addr2']
	)));
	$res = json_decode(curl_exec($curl), true);
	curl_close($curl);
	echo json_encode($res);
}

function guarantee() {
	header('Content-type: text/plain');
	header('Content-Disposition: attachment; filename="LetterGuarantee.txt"');
	echo @$_REQUEST['text'];
	exit();
}
