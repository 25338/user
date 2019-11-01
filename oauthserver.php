<?
//проверка авторизация в единой системе авторизации
if(isset($_POST['getid']) ){
	include "db.php";

	$login=$_POST['login'];
	$passw=$_POST['passw'];

	$rec=array();

	$sql="select * from u ";
	$res=$conn->query($sql);
	while($row=$res->fetch_array()){
		if( password_verify($passw, $row['pass']) && $login==$row['login'] ) {
			$rec=array(
				'id'=>$row['id'], 
				'login' =>$login, 
				'user_group'=>$row['user_group'], 
				'user_name'=>$row['user_name'], 
				'blocked'=>$row['blocked'], 
				'token'=>$row['token'],
			);
			break;
		}
	}
	$conn->close();
	$response = json_encode( $rec );
	print_r($response);
}
?>