<?
$oauth_url="http://user.localhost/oauthserver.php";

$login=htmlspecialchars($_POST['_username'], ENT_QUOTES);
$passw=htmlspecialchars($_POST['_password'], ENT_QUOTES);

if($login && $passw){
	$params=array(
		'getid' =>'getid',
		'login' => $login,
		'passw' => $passw,
	);
	$query=http_build_query($params);
	$opts = array('http' =>array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $query
    	)
	);
	$context  = stream_context_create($opts);
	$content=@file_get_contents($oauth_url,false, $context);
	$res=json_decode($content);
	$_SESSION['myToken']=$res;
}
?>