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
$sort="";
$images=array();
$groups=array();
$getpage=false;

//require('trick.php');

/*
if(isset($_SESSION['images']))	$images = $_SESSION['images'];
if(isset($_SESSION['groups']))	$groups	= $_SESSION['groups'];
if(isset($_SESSION['sort']))	$sort	= $_SESSION['sort'];
if(isset($_SESSION['album']))	$album	= $_SESSION['album'];

if(isset($_POST['action']))		$action	= $_POST['action'];
if(isset($_POST['page']))		$page 	= $_POST['page'];
if(isset($_POST['album'])){
		$album 	= $_POST['album']."/";
		$_SESSION['album'] = $_POST['album']."/";
}
if(isset($_POST['sort'])){
	$sort			=	$_POST['sort'];
	$_SESSION['sort']	=	$_POST['sort'];
}

if(isset($_GET['action'])){
		$action	= $_GET['action'];
		$getpage=true;
}
if(isset($_GET['page'])){
	$page 	= $_GET['page'];
	$getpage=true;
}
if(isset($_GET['album'])){
		$album 	= $_GET['album']."/";
		$_SESSION['album'] = $_GET['album']."/";
}
if(isset($_GET['sort'])){
	$sort			=	$_GET['sort'];
	$_SESSION['sort']	=	$_GET['sort'];
}

if($album=="" && $image!=""){
	$album=dirname($image);
}
*/

if(isset($_GET['f'])) $f=$_GET['f'];

echo "$f</br>";
if(!check_path($f)) die("Unauthorized access");
if(!file_exists($f)) die("Unknown file");

if(is_dir($f)){
	// This is an album
	$album=$f;
	$action="album";
	$image=-1;
}else if(is_file($f)){
	// This is a picture
	$album		=	dirname($f);
	$albumname	=	basename($album);
	$image		=	$f;
	$action		=	"image";
}


$album=str_replace("//","/",$album);


$myscope=realpath($dirname);
$path_required=realpath($album);

if(strncmp($path_required, $myscope, strlen($myscope)) != 0){ 
	die("This album isn't available."); 
}



if(!isset($groups))  $groups = array();

$albumname=str_replace("_"," ",substr($album,strrpos($album,"/",-2)+1,-1));


if ($page < 1 || $getpage) echo ("<script>setup_keyboard(); update_title('$title - $albumname');</script><div id='albumname'>$albumname</div><ul id='album_contents'>");

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


