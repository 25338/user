<?
$title_module=$kw[$uri[2]][1];
$action='/login/list_user/';

//страница
$page=intval($_REQUEST["page"]);if($page<1){$page=1;}

$err="";
$tag=1;
$do=$_REQUEST["do"];
$id=intval($_REQUEST["id"]);

if(isset($_POST['save'])){
	$edit_user_group=intval($_POST['edit_user_group']);
	$edit_user_name=htmlspecialchars($_POST['edit_user_name'], ENT_QUOTES);
	$org_name=htmlspecialchars($_POST['org_name'], ENT_QUOTES);
	$email=htmlspecialchars($_POST['email'], ENT_QUOTES);

	$lgn=strip_tags($_POST['lgn']);
	$now=date("YmdHis");
	$psw=$_POST['psw'];
	$pass=password_hash($psw, PASSWORD_DEFAULT);
	$password=(trim($psw)) ? ", pass='".$pass."', pass_date='$now'" : '';

	$user_blocked=($_POST['user_blocked']) ? 1 : 0;

	//создаем токен
	$data="MuhUra75".date("YmdHis");
	$token=hash("sha256",$data);
	$hash=", token='".$token."'";

	$data=getrec($conn, "u","id", "where login='".$lgn."' and id<>".$id);
	if(intval($data['id'])>0){
		$err=$kw['user_found'][1];
		$tag=2;
	}else{
		$set="set user_name='$edit_user_name', login='$lgn', user_group=$edit_user_group, 
		org_name='$org_name', email='$email', blocked=$user_blocked ".$password;
		$sql=($id) ? "update u ".$set." where id=$id" : "insert into u ".$set. $hash;
		$conn->query($sql);
		$id=0;
	}
}

if($do=='add' || $id>0){ $tag=2;}
?>
<div class="div-padding" >

<?
//показать название школы
if($tag==1){ ?>
<div class="title-module">
	<? echo $title_module;?>
	<a href="<? echo $action;?>?do=add" class="btn btn-primary btn-sm btn-action" ><i class="fas fa-plus"></i> <? echo $kw["add"][1];?></a>
</div>

<div class="bg-white">
	<table class="table table-bordered table-sm table-striped text_13">
		<thead class="thead-dark">
			<tr>
				<th class="text-center" style="width: 40px;"><? echo $kw['#'][1];?></th>
				<th class="text-center" style="width: 40px;">ID</th>
				<th><? echo $kw["login"][1];?></th>
				<th><? echo $kw["user_name"][1];?></th>
				<th><? echo $kw["email"][1];?></th>
				<th><? echo $kw['org_name'][1];?></th>
				<th><? echo $kw['user_group'][1];?></th>
				<th class="text-center"><? echo $kw['pass_date'][1];?></th>
				<th class="text-center"><? echo $kw['status'][1];?></th>
				<th class="text-center" style="width: 130px;"><? echo $kw['actions'][1];?></th>
			</tr>
		</thead>
		<tbody>
<?
$j=0;
$p=($page-1)*$max_view;
$sql="select * from u where user_group<>1 order by user_name limit $p,$max_view";
$res=$conn->query($sql);
while($row=$res->fetch_array()){
	$j++;
	$id=$row['id'];
	$login=$row['login'];
	$user_name=$row['user_name'];
	$email=$row['email'];
	$org_name=$row['org_name'];
	$user_group=$row['user_group'];
	$blocked=( intval($row['blocked'])>0 ) ? $kw['blocked'][1] : '';
	$pass_date=load_datetime($row['pass_date']);
?>
			<tr >
			<td class="align-middle text-center"><? echo $j;?></td>
			<td class="align-middle text-center"><? echo $id;?></td>
			<td class="align-middle"><? echo $login;?></td>
			<td class="align-middle"><? echo $user_name;?></td>
			<td class="align-middle"><? echo $email;?></td>
			<td class="align-middle"><? echo $org_name;?></td>
			<td class="align-middle"><? echo $auser_group[$user_group];?></td>
			<td class="align-middle text-center"><? echo $pass_date;?></td>
			<td class="align-middle text-center" ><? echo $blocked;?></td>
			<td>
				<a class="btn btn-success btn-sm" href="<? echo $action;?>?page=<? echo $page;?>&id=<? echo $id;?>" ><i class="far fa-edit"></i> <? echo $kw["edit"][1];?></a>
			</td>
			</tr>
<? } ?>
		</tbody>
	</table>
</div>
<?
	//нумерация страниц
	$url1="/" .$uri[1]."/".$uri[2]."/?";
	$tables="u";
	$where=" where user_group<>1 ";
	$data=getrec($conn, $tables, "count(*)", $where);
	$maxrec=intval($data[0]);
	echo ' <div class="text_13">'.$kw["all_rec"][1].': <b>'.$maxrec.'</b></div>';
	$max_page=$maxrec/$max_view+1;
	if($max_page>2){ 
		echo navLinks($maxrec, $page, $url1);
	}

//конец if(tag=1)
}

//
//
//процедура редактирование школы
if($tag==2){
	if($id){
		$data=getrec($conn, "u","*",'where id='.$id);
		$lgn=$data['login'];
		$edit_user_name=$data["user_name"];
		$edit_user_group=intval($data['user_group']);
		$user_blocked=($data['blocked']) ? 'checked' : '';
		$email=$data['email'];
		$org_name=$data['org_name'];
	}
?>
<div class="title-module"><? echo $title_module;?></div>
<form method="POST" action="<? echo $action;?>?page=<? echo $page;?>">
<input type="hidden" name="id" value="<? echo $id;?>">

<div class="container bg-white">
	<div class="row align-items-center row-padding">
		<div class="col-3 text-right"><? echo $kw['user_group'][1];?>:</div>
		<div class="col-4">
			<select class="form-control form-control-sm" name="edit_user_group" required >
				<option></option>
				<?
				foreach ($auser_group as $key => $value) {
					if($key>1){
						$sel=($key==$edit_user_group) ? 'selected' : '';
						echo '<option value="'.$key.'" '.$sel.'>'.$value.'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>

	<div class="row align-items-center row-padding">
		<div class="col-3 text-right"><? echo $kw['user_name'][1];?>:</div>
		<div class="col-4">
			<input type="text" class="form-control form-control-sm" name="edit_user_name" required value="<? echo $edit_user_name;?>" >
		</div>
	</div>

	<div class="row align-items-center row-padding">
		<div class="col-3 text-right"><? echo $kw['org_name'][1];?>:</div>
		<div class="col">
			<input type="text" class="form-control form-control-sm" name="org_name" value="<? echo $org_name;?>" >
		</div>
	</div>

	<div class="row align-items-center row-padding">
		<div class="col-3 text-right"><? echo $kw['email'][1];?>:</div>
		<div class="col-4">
			<input type="text" class="form-control form-control-sm" name="email" value="<? echo $email;?>" >
		</div>
	</div>

	<div class="row align-items-center row-padding">
		<div class="col-3 text-right"><? echo $kw["login"][1];?>:</div>
		<div class="col-4">
			<input type="text" class="form-control form-control-sm" name="lgn" value="<? echo $lgn;?>" required>
		</div>
		<div class="col" style="padding-left: 0;">
			<span class="text-danger login_message" id="message"> <b><? echo $err;?></b></span>			
		</div>
	</div>

	<div class="row align-items-center row-padding">
		<div class="col-3 text-right"><? echo $kw["password"][1];?>:</div>
		<div class="col-4">
			<input type="password" class="form-control form-control-sm" name="psw" maxlength="30">
		</div>
		<div class="col" style="padding-left: 0px; color: grey;">
			<i>(<? echo $kw['password_free'][1];?>)</i>
		</div>
	</div>
	<div class="row align-items-center row-padding">
		<div class="col-3 text-right"><? echo $kw["user_blocked"][1];?>:</div>
		<div class="col-1">
			<input class="width-checkbox" type="checkbox" value="1" name="user_blocked" <? echo $user_blocked;?> >
		</div>
	</div>

	<br>
	<div class="row align-items-center row-padding">
		<div class="col-3"></div>
		<div class="col">
			<button type="submit" class="btn btn-primary btn-sm" name="save"> 
			<i class="fas fa-save"></i> <? echo $kw["save"][1];?>
			</button> 
			<a href="<? echo $action;?>?page=<? echo $page;?>" class="btn btn-secondary btn-sm" >
			<i class="fas fa-ban"></i> <? echo $kw["close"][1];?>
			</a>
		</div>
	</div>
</div>
</form>

<script src="/js/myscript.js"></script>

<?  
} //конец if(tag=2)
?>
</div>
