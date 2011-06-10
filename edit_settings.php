<?php 
/*
*  Created by Thibaud Rohmer on 2011-05-12.
*/
session_start();
define("ME_IZ_GOOD","true");
require "settings.php";
require "pass.php";

if(!isset($_SESSION['pass'])) $_SESSION['pass']='';

if(isset($_POST['pass'])) $_SESSION['pass']=$_POST['pass'];

$pass=$_SESSION['pass'];

/************ Important Variables ******************/
$main=array();
$main["title"]		=	"Website Title";
$main["url"]		=	"URL to access Website (for RSS feed)";
$main["dirname"]	=	"Directory where the photos are stored";
$main["virtual"]	=	"Directory to store virtual albums";
$main["thumbdir"]	=	"Directory where the thumbnails are stored";
$main["limit"]		=	"Number of pictures per page";
$main["theme"]		=	"Style (black_knight or snow_white";
$main["mod"]		=	"Style Mod (not available at the moment)";

$menu=array();
$menu["menubar_left"]	=	$menubar_left;
$menu["menubar_center"]	=	$menubar_center;
$menu["menubar_right"]	=	$menubar_right;
	


function setting($valname,$val,$desc){
	echo "<tr><td align='right'>$valname :</td><td> <input type='text' name=\"$valname\" value='".addslashes($val)."'/></td><td>$desc</td></tr>";
}

function setting_cb($valname,$val,$checked,$desc){
	echo "<tr><td>$val :</td><td> <input type='checkbox' name='$valname' value='$val'";
	if($checked=="true") echo "checked='yes'";
	echo "></td><td>$desc</td></tr>";
}

function setting_cb_table($valname,$val,$checked){
	echo "<tr><td> <input type='checkbox' name='$valname' value='$val'";
	if($checked=="true") echo "checked='yes'";
	echo "> $val</td></tr>";
}


function load_dirs($album,$thumbdir){
        if(strpos("..",$album)>-1) return;

        $dir = scandir($album);

        for($i=0;$i<sizeof($dir);$i++)
        {
                $file=$album."/".$dir[$i];
                if(is_dir($file) && substr($file,-1,1)!="."){
               		$authorized=array();
                	if(is_file($thumbdir."/".$file."/authorized.txt")){
                        	$lines=file($thumbdir."/".$file."/authorized.txt");
                        
				foreach($lines as $line_num => $line){
                                	$authorized[]=substr($line,0,strlen($line)-1);  // substr is here for taking car of the "\n" 
				}
			}

                        $images[$file]=$authorized;
                        $images_new=load_dirs($file,$thumbdir);
                        if(sizeof($images_new)>0){
                                if(sizeof($images)>0){
                                        $images=array_merge($images,$images_new);
                                }else{  
                                        $images=$images_new;
                                }
                        }
                }
        }
        return $images;
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="author" content="Thibaud Rohmer" >

		<link rel="icon" type="image/ico" href="favicon.ico">
		<title>PhotoShow</title>
	
		<link rel='stylesheet' href='stylesheets/settings.css' type='text/css' media='screen' title='no title' charset='utf-8'>
        	<script src='jQuery/jquery.min.js' type="text/javascript" charset="utf-8"></script>

		<script>
		$(document).ready(function() {

			$(".hidden").hide();
			$(".folder a").click(function(){
				$(this).parent().next().slideToggle();
			});
			$(".content").hide();
			$("h2").click(function(){
				$(this).next().slideToggle("slow");
			});
			$("#login").show();
		});

		function addrow(){
			$("#grouptable").append("<tr><td><input type='text' name='newgroup[]'></td><td><input type='password' name='newpass[]'></td></tr>");
			return false;
		}
		</script>
</head>
<body>
<div id="wrapper">
	<div id="banner">
		<span class="photo">Photo</span><span class="show">Show</span> - Settings
	</div>

	<a href="index.php">Back to Website</a>


<?php		
if(isset($_POST['dirname'])){
	echo('<div class="info">
		<h2>Result</h2>
		<div class="content">
	');
	$s_f=fopen("./settings.php","w+");
	fwrite($s_f,"<?php\n /*\n * Created By Thibaud Rohmer\n*/ require 'default_settings.php';\n");
	
	$buffer="/******** MAIN *******/\n";
	foreach($main as $k => $v){
		$buffer=$buffer."// $v\n \$$k=\"".$_POST[$k]."\";\n";
	}
	fwrite($s_f,$buffer);

	$buffer="/******** BUTTONS *******/\n";
	foreach($buttons as $k => $v){
		$buffer=$buffer."\$$k=\"".$_POST[$k]."\";\n";
	}
	fwrite($s_f,$buffer);

	$buffer="/******** MENUBAR *******/\n";
	foreach($menu as $k => $v){
		$buffer= $buffer."\$$k=array(";
		$stupid_test=0;
		foreach($_POST[$k] as $k => $v){
			if($stupid_test==1) $buffer=$buffer.",";
			$buffer=$buffer."'$v'";
			$stupid_test=1;
		}
		$buffer=$buffer.");\n";	
	}
	fwrite($s_f,$buffer);
	fwrite($s_f,"?>");
	fclose($s_f);

	$g_f=fopen("./pass.php","w+");
	$buffer="<?php\n /*\n * Created by Thibaud Rohmer\n*/\n/******* GROUPS ******/\n if(!defined('ME_IZ_GOOD')) die('You = bad man.');\n";
	$buffer=$buffer."// If you remove the admin account, it will still exist will password : passadmin\n \$groups['admin']='".sha1("passadmin")."';\n";
	fwrite($g_f,$buffer);
	$buffer="";
	foreach($_POST['groups'] as $k => $v){
		if( $_POST['group_pass'][$v] != '')
			$buffer=$buffer."\$groups['$v']='".sha1($_POST['group_pass'][$v])."';\n";
		else
			$buffer=$buffer."\$groups['$v']='".$groups[$v]."';\n";
	}
	fwrite($g_f,$buffer);
	$buffer="";
	foreach($_POST['newgroup'] as $k => $v){
		$newgrouppass=$_POST['newpass'][$k];
		if(isset($groups[$v])){
			echo "The group $k already exists</br>";
		}else{
			if($v != '' && $newgrouppass != ''){
				echo "$v added</br>";
				$buffer=$buffer."\$groups['$v']='".sha1($newgrouppass)."';\n";
			}
		}
	}
	
	fwrite($g_f,$buffer);
	fwrite($g_f,"?>");
	fclose($g_f);

	$total_groups=count($groups);
	foreach($_POST['folders'] as $k => $v){
		$auth=$thumbdir."/".$k."/authorized.txt";
		$free=(sizeof($v)==$total_groups);
		if($free && is_file($auth)){
			unlink($auth);
			if(!is_file($auth)){ 
				echo "$auth Deleted</br>";
			}else{
				echo "Couldn't Delete $auth : check your rights.";
			}
		}
		if(!$free){
			$buffer="";
			foreach($v as $w => $z){
				$buffer=$buffer."$z\n";
			}
			$tmp_f=fopen($auth,"w+");
			fwrite($tmp_f,$buffer);
			fclose($tmp_f);
			echo "$auth : $buffer</br>";
		}

	}
require "settings.php";
require "pass.php";

	echo "</div></div>";
}

?>

	<form method="post">
<?php
	if(sha1($pass) != $groups['admin']){
		echo("
		<div class='info'>
			<h2>Login</h2>
			<div class='content' id='login'>Please login:</br>
			<input type='password' name='pass'><input type='submit' value='login'>
			</div>
		</div>
		</form>
		</div>");
		break;
	}
?>


	<div class="info">
		<h2>Main Settings</h2>
		<div class="content">
		<table>
			<?php 


			foreach ($main as $k => $v) {
				setting($k,$$k,$v); 
			}
			setting_cb("slow_conn","slow_conn",$slow_conn,"Generate pictures for slow connections");
			?>
		</table>
		</div>
	</div>

	<div class="info">
		<h2>Button names</h2>
		<div class="content">
		<table>
		<?php 
			foreach ($buttons as $k => $v) {
				setting($k,$v); 
			}
		?>
		</table>
		</div>
	</div>

	<div class="info">
		<h2>Menubar</h2>
		<div class="content">
		<table class='nicetable'><tr>
		<?php
		foreach ($menu as $menuname => $menubar) {
			echo "<td>$menuname<table>";
			foreach ($buttons as $k => $v) {
				$checked="false";
				if(in_array($k,$menubar)) $checked="true";
				setting_cb_table($menuname.'[]',$k,$checked);
			}
			echo "</table></td>";
		}
		?>
		</tr></table>
		</div>
	</div>

	<div class="info">
		<h2>Groups</h2>
		<div class="content">
		Keep those groups :
		<table>
		<?php
		foreach($groups as $k=> $v){
			setting_cb_table("groups[]",$k,"true");
		}
		?>
		</table>
		To change a group's password, edit corresponding field (else, keep blank) :
		<table>
		<?php
		foreach ($groups as $k => $v){
			setting("group_pass[$k]");
		}
		?>
		</table>
		To add a group, type in its name and password (only the groups with both info will be added) :
		<table class="nicetable" id="grouptable"><tr>
		<td>Group Name</td><td>Group Password</td>
		<tr><td><input type="text" name="newgroup[]"></td><td><input type="password" name="newpass[]"></td></tr>
		</table>
		<button onClick="return addrow()" value="+">
		</div>
	</div>

<?php  $dirs=load_dirs($dirname,$thumbdir); ?>

	<div class="info">
		<h2>Rights</h2>
		<div class="content">
		<?php
		foreach($dirs as $k => $v){
			if(sizeof($v)==0){
				echo "<div class='folder'><a class='free'>$k</a></div><div class='hidden'><table>";
			}else{
				echo "<div class='folder'><a>$k</a></div><div class='hidden'><table>";
			}
			foreach($groups as $q => $w){
				$checked="false";
				if(in_array($q,$v) || sizeof($v)==0) $checked="true";
				setting_cb_table("folders[$k][]",$q,$checked);
			}
			echo "</table></div>";
		}
		?>		
	</div>

	<input type='submit'>
	</form>

</body>
</html>
