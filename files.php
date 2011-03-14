<?php
/*
*  Created by Thibaud Rohmer on 2010-12-23.
*/

if(!isset($_SESSION["logged"])){
	session_start();
	$_SESSION["logged"]=true;
}

require_once "settings.php";
require_once "functions.php";

define("IS_IN_MY_APP", "TRUE");

$action="";
$album="";
$page="";
$images=array();
$groups=array();

if(isset($_SESSION['images']))	$images = $_SESSION['images'];
if(isset($_SESSION['groups']))	$groups	= $_SESSION['groups'];

if(isset($_POST['action']))		$action	= $_POST['action'];
if(isset($_POST['album']))		$album 	= $_POST['album']."/";
if(isset($_POST['page']))		$page 	= $_POST['page'];

$album=str_replace("//","/",$album);

if(!isset($groups))  $groups = array();

$albumname=str_replace("_"," ",substr($album,strrpos($album,"/",-2)+1,-1));


if ($page < 1) echo ("<script>setup_keyboard();</script><div id='albumname'>$albumname</div><ul id='album_contents'>");


if($action=="album"){
	$images=array();
	$new_dir=array();
	
	$images=load_images($album,$groups,1);

	if(sizeof($images)==0){
		$_SESSION['album']=$album;
		echo "<script>$('#logindiv').children().first().load('login.php', { album: '$album' } ); $('#logindiv').show();</script>";
		die();
	}
	
	if($sort_all_by_age) array_multisort(array_map('filemtime', $images), SORT_DESC, $images); 
	$images=str_replace("//","/",$images);
	
}elseif($action=="age"){
	$images=sort_by_date($groups,$album);

}elseif($action=="random"){
	$images=sort_by_random($groups,$album);

}elseif($action=="virtual"){
	$images=array();
	$lines=file($album);
	foreach($lines as $line_num => $line)
		$images[]=$line;

}elseif($action=="go_on"){
// Do nothing

}else{
	die("Error");

}

	$size_dir=sizeof($images);

$_SESSION['images']=$images;


display_thumbnails($images,$page*$limit,$limit);	


$imagesphp=array_to_get($images,"album");

$nextpage=$page+1;

if ($page < 1) echo ("<li class='end'>More...</li></ul>");


if($page<1) {
	echo("
	<script>
	$(document).ready(function() {
		
		change_display('init');	
		var page = 0;
		
		
		var limit=$limit;
		var size_dir=$size_dir;
		
		if((page+1)*limit + 2 >= size_dir) {
			$('.end').remove();
		}
		
		$('.end').click(function(){
			$(this).remove();
			page++;
			display_more(page,limit,size_dir);
		});
		
		
	});
	</script>
	");

}
?>


