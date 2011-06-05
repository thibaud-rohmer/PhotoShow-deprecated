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

if(isset($_POST['f'])) $f=$_POST['f'];
if(isset($_GET['f'])) $f=$_GET['f'];
if(isset($_POST['p'])) $page=$_POST['p'];
if(isset($_GET['p'])) $page=$_GET['p'];

action($f);

if(!isset($groups))  $groups = array();

if ($page < 1 ) echo ("<script>setup_keyboard(); update_title(\"$title - $albumname\");</script><div id='albumname'>$albumname</div><ul id='album_contents'>");

if($action=='' && isset($_GET['image'])) $action="image";
if($action=='' && isset($_GET['album'])) $action="album";

if( ($action=="album" && $album != "") || $action=="image" ){
	$images=array();
	$new_dir=array();
	
	$images=load_images($album,$groups,1);

	if(sizeof($images)==0){
		$_SESSION['album']=$album;
		echo "<script>$('#logindiv').children().first().load('login.php', { album: '$album' } ); $('#logindiv').show();</script>";
		die();
	}
	
	$images=str_replace("//","/",$images);

	switch ($sort){
		case "date_desc" :
			array_multisort(array_map('filemtime', $images), SORT_DESC, $images);
			break;
		case "date_asc" :
			array_multisort(array_map('filemtime', $images), SORT_ASC, $images);
			break;
		case "name" :
			sort($images);
			break;
	}

}elseif($action=="virtual"){
	$images=array();
	$lines=file($album);
	foreach($lines as $line_num => $line)
		$images[]=$line;

}


	$size_dir=sizeof($images);

$_SESSION['images']=$images;

if($getpage){
	display_thumbnails($images,0,($page+1)*$limit);	
}else{
	display_thumbnails($images,$page*$limit,$limit);	
}

$imagesphp=array_to_get($images,"album");

$nextpage=$page+1;

if ($page < 1 || ($getpage && ($page+1)*$limit + 2 <= $size_dir)) echo ("<li class='end'><a href='./index.php?page=$nextpage'>More...</a></li></ul>");


if($page<1) {
	echo("
	<script>
	$(document).ready(function() {
	");
	if(!$getpage && $action!="image"){
		echo ("change_display('init');");
	}else{
		echo ("change_display('initpic');");
	}
	echo("
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


