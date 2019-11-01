<?
//подключаем шапку страницы сайта
include_once "admhead.php";

//получаем текущего пользователя
$data=getrec($conn, "u","*", "where id=$admin_id");
$user_name=$data["user_name"].' ('.'ID:'.$data['id'].')';
$user_group=intval($data["user_group"]);

//массив функции админ панели
$menus=array(
	'list_user'  =>array($kw['list_user'][1], 'adm_user.php','1','fas fa-users'),
	'profile'=>array($kw['myprofile'][1], 'adm_profile.php','0',''),
	'cpassw'=>array($kw['cpassw'][1], 'adm_cpassw.php','0',''),
);

$now=$kw["today"][1].': '.date("d-m-Y").' '.mb_strtolower($day_week[date("N")]).' '; 
$now.='<span class="clock">'.date("H:i:s").'</span> ';

?>
<div class="fixed-top d-flex align-items-center header shadow" >
	<div class="d-flex align-items-center header-left" >
		<div class="header-img">
			<a href="/" ><img src="/img/browser.png" width="32" align="left" vspace="6"></a>
		</div>
		<div>
			<div class="header-1"><? echo $kw['appname'][1];?></div> 
			<div class="header-2"><? echo $kw['adminpanel'][1];?></div>
		</div>
	</div>
	<div class="header-center"><? echo $now; ?></div>
	<div class="ml-auto header-right">
		<div class="mydropdown">
			<a class="btn btn-sm btn-dark dropdown-toggle prof" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><? echo $user_name;?> <i class="fas fa-user-circle"></i></a>
			<div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="dropdownMenuLink">
		    	<a class="dropdown-item profile" href="/login/profile/"><i class="fas fa-user-circle"></i> <? echo $kw["myprofile"][1];?></a>
		    	<a class="dropdown-item profile" href="/login/cpassw/"><i class="fas fa-key"></i> <? echo $kw["cpassw"][1];?></a>
		    	<div class="dropdown-divider"></div>
		    	<a class="dropdown-item profile" href="/exit/"><i class="fas fa-sign-out-alt"></i> <? echo $kw["exit"][1];?></a>
			</div>
		</div>
	</div>
</div>

<div class="row no-gutters side">
	<div class="left-side shadow">
		<?
		//строим меню из массива
		foreach($menus as $key=>$menu){
			$ar=explode(",", $menu[2]);
			if( in_array($user_group, $ar ) ) {
				$sel=($key==$uri[2]) ? "left_menu_sel":"";
				echo '<a href="/login/'.$key.'/" style="text-decoration:none;">';
				echo '<li class="left_menu '.$sel.'"> ';
				echo '<i class="'.$menu[3].'" style="width:20px;"></i> ';
				echo $menu[0];
				echo '</li>';
				echo '</a>';
			}
		}
		?>
	</div>
	<div class="center-side" >
		<?
		//проверяем существование файла, если есть подключаем
		$key=$uri[2];
		$sel_file=$menus[$key][1];
		if(file_exists($sel_file)){
			include $sel_file;
		}else{
			$uri[2]='list_user';
			include "adm_user.php";
		}
		?>
	</div>
</div>

<script>
setInterval(function(){
        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();

        // Add leading zeros
        minutes = (minutes < 10 ? "0" : "") + minutes;
        seconds = (seconds < 10 ? "0" : "") + seconds;
        hours = (hours < 10 ? "0" : "") + hours;

        // Compose the string for display
        var currentTimeString = hours + ":" + minutes + ":" + seconds;
        $(".clock").html(currentTimeString);

}, 500);
</script>