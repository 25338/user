<?

$tag=1;
$saved=" ";
//сохранить запись
if(isset($_POST['save_profile'])){
	$edit_user_name=htmlspecialchars($_POST['edit_user_name'], ENT_QUOTES);

	$set="set user_name='$edit_user_name'";
	$sql="update u ".$set." where id=".$admin_id;
	$conn->query($sql);
	$saved=$kw['saved'][1];
}

// данные авторизованного пользователя
$data=getrec($conn, "u","*","where id=".$admin_id);
$edit_user_name=$data['user_name'];
$login=$data['login'];

?>

<div class="div-padding">
<div class="title-module"><? echo $kw['myprofile'][1];?></div>
<form method="POST" >
<div class="container bg-white">

	<div class="row align-items-center row-padding">
		<div class="col-3 text-right"><? echo $kw['login'][1];?>:</div>
		<div class="col-3">
			<input type="text" readonly class="form-control form-control-sm text_13" value="<? echo $login;?>" >
		</div>
	</div>

	<div class="row align-items-center row-padding">
		<div class="col-3 text-right"><? echo $kw['user_name'][1];?>:</div>
		<div class="col-6">
			<input type="text" name="edit_user_name" maxlength="100" class="form-control form-control-sm text_13" value="<? echo $edit_user_name;?>" required>
		</div>
	</div>

	<div class="row align-items-center row-padding">
		<div class="col-3"></div>
		<div class="col">
			<button type="submit" class="btn btn-primary btn-sm" name="save_profile" value="<? echo $kw["save"][1];?>"> 
			<i class="fas fa-save"></i> <? echo $kw["save"][1];?></button> 
			<a href="/login/" class="btn btn-dark  btn-sm" ><i class="fas fa-times"></i> <? echo $kw["close"][1];?></a>
			<span id="message" class="login_error"><? echo $saved;?></span>
		</div>
	</div>
</div>
</form>
</div>
<script src="/js/myscript.js"></script>
