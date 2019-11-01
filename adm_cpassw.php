<?
$tag=1;
$saved="";

//сохранить запись
if(isset($_POST['save_profile'])){
	$oldpassword=$_POST['oldpassword'];
	$newpassword=$_POST['newpassword'];
	$renewpassword=$_POST['renewpassword'];
	
	$data=getrec($conn, "u","*", "where id=".$admin_id);
	$pas=$data['pass'];

	if( password_verify($oldpassword, $pas) && $newpassword==$renewpassword) {
		$newpassword=password_hash($newpassword, PASSWORD_DEFAULT);
		$set=' pass="'.$newpassword.'"';
		$sql='update u set '.$set.' where id='.$admin_id;
		$conn->query($sql);
		$saved=$kw['pass_saved'][1];
	}else{
		$saved=$kw['error_pass'][1];
	}

}


if($tag==1){ ?>

<div class="div-padding">
<div class="title-module"><? echo $kw['cpassw'][1];?></div>

<form method="POST">
<div class="container bg-white">
	<div class="row align-items-center row-padding">
		<div class="col-3 text-right"><? echo $kw["oldpassword"][1];?>:</div>
		<div class="col-4">
			<input type="password" name="oldpassword" maxlength="30" class="form-control form-control-sm text_13" required>
		</div>
	</div>
	<span class="divider"></span>
	<div class="row align-items-center row-padding">
		<div class="col-3 text-right"><? echo $kw['newpassword'][1];?>:</div>
		<div class="col-4">
			<input type="password" name="newpassword" maxlength="30" class="form-control form-control-sm text_13" required>
		</div>
	</div>

	<div class="row align-items-center row-padding">
		<div class="col-3 text-right"><? echo $kw['renewpassword'][1];?>:</div>
		<div class="col-4">
			<input type="password" name="renewpassword" maxlength="30" class="form-control form-control-sm text_13" required>
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
<?
}
?>

