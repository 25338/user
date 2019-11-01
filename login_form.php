<? 
include "admhead.php";
?>
<div style="height:30px;" ></div>
<div class="login-form shadow">
	<div class="login-header">
		<? echo $title_site;?>
	</div>
	<div class="text-center">
		<form method="POST" >
			<div class="login-body">
				<div class="text_16"><? echo $kw['autorization'][1];?></div>
				<span class="login_error text_13" id="message"><b><? echo $err;?></b></span>
				<br>
				<input name="_username" class="form-control text_13" value="" type="text" placeholder="<? echo $kw["login"][1];?>" required autofocus="">
				<br>
				<input name="_password" class="form-control text_13" type="password" placeholder="<? echo $kw["password"][1];?>" required>
				<br>
				<button type="submit" name="enter" class="btn btn-primary" value="<? echo $kw["enter"][1];?>" style="padding: 4px 20px !important;">
				<i class="fas fa-sign-in-alt"></i> <? echo $kw["enter"][1];?>
				</button>
			</div>
		</form>
	</div>
</div>

<script src="/js/myscript.js"></script>