<?php 

if(!isset($_SESSION["logged"])){
	session_start();
	$_SESSION["logged"]=true;
}

require_once "settings.php";
require_once "functions.php";

define("IS_IN_MY_APP", "TRUE");

$action=$_POST["action"];
$img=$_POST["img"];

?>

<div class="close">
	<a href="#">x</a>
</div>

<?php
/*
*  Created by Thibaud Rohmer on 2010-12-23.
*/

if(isset($_SESSION['groups']))	$groups	= $_SESSION['groups'];


if(!isset($groups))  $groups = array();

$authorized[0]="admin";
if(sizeof(array_intersect($groups,$authorized))==0){
	echo "Only the admin can view this</br>";
	$included=1;
	include "login.php";
	return;
}else{
	if(file_exists($img) && !is_dir($img))
	if($action=="delete") {
		$res=unlink($img);
		echo("<script>del_select_next();</script>");
	}
}


echo("
<script type='text/javascript'>

function doyourstuff(my_action){
	setup_keyboard();
	$('#admindiv .content').load('admin.php', {  action: my_action, img: '$img' } );
}");

?>

$(document).ready(function() {	
	$('#delete').click(function(){
		doyourstuff("delete");
	});
	
	
	$('#admindiv input').focus(function(){
		remove_keyboard();
	});

	$(".close").click(function(){
		$(this).parent().parent().fadeOut("slow");
	});
});    


</script>

<form accept-charset="utf-8" >	
	<div id="delete" class="formvalidate">Delete</div>
</form>




