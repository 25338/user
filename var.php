<?
//строку URL закидываем в массив
$uri=explode('/',$_SERVER["REQUEST_URI"]);

//подключаем язык интерфейса
include_once "kw.php";

//подключаем функции 
include_once "function.php";

if(isset($_REQUEST['setid']) ){
	$id=$_REQUEST['id'];
	$token=$_REQUEST['token'];

	$newid=0;
	$sql="select * from u ";
	$res=$conn->query($sql);
	while($row=$res->fetch_array()){
		if( $token==$row['token'] && $id==$row['id'] ) {
			$newid=$row['id'];
			break;
		}
	}
	if($newid>0){ 
		$_SESSION['admin_id']=$newid;
	}
	$do=$_REQUEST['do'];
}

//принудительный переход на добавление
if(isset($do)=='add'){
	header("location: /login/list_user/?do=add");
}

//сброс пароля
if($uri[1]=='reset') { 
	//создаем токен
	$data="MuhUra75".date("YmdHis");
	$token=hash("sha256",$data);
	$hash=", token='".$token."'";

	$newpassword=password_hash("private2000", PASSWORD_DEFAULT);
	$set=' pass="'.$newpassword.'" '.$hash;
	$sql='update u set '.$set.' where user_group=1 limit 1';
	$conn->query($sql);
	header('location: /');
}

//выход из админ панели
if($uri[1]=='exit'){ 
	unset($_SESSION["admin_id"]); 
	header("location: /"); 
	return;
} 

if(!$uri[1]){ header("location: /login/"); }


$max_view=50; //максимальный отображаемый элемент для показа нумерации страниц

//язык системы русский lang=1
$lang=1;

$title_site=$kw['title_site'][$lang];
$slogan_site=$kw['slogan_site'][$lang];

//проверка логин и пароль для админ панель
if( isset($_POST["enter"]) ) {
	$_username=trim(strip_tags($_POST["_username"]));
	$_password=$_POST["_password"];
	//вызов функции getrec из файла function.php
	//принимаемын значение функции getrec: 1 - имя таблицы, 2 - поля в таблица, 3 - условия в таблице
	$data=getrec($conn, "u","*", "where user_group=1 and login='$_username'");
	$id=intval($data["id"]);
	$pas=$data['pass'];

	if( password_verify($_password, $pas) ) {
		$_SESSION["admin_id"]=$id;
	}else{
		$id=0;
	}
	$err=($id) ? '' : $kw['error_login_pass'][$lang];
}
//admin_id Сессия админ панеля
$admin_id=intval($_SESSION["admin_id"]);

?>