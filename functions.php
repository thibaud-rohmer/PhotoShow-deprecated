<?php 
/*
*  Created by Thibaud Rohmer on 2010-12-23.
*/


if(!isset($_SESSION["logged"])){
	session_start();
	$_SESSION["logged"]=true;
}

/* list_allowed
* Returns a list of the people allowed to see this amazing stuff
*/
function list_allowed($dir){
	require('settings.php');
	if(is_file($dir)) $dir=dirname($dir);

	$groups = array();
	if(isset($_SESSION['groups'])) $groups = $_SESSION['groups'];
	$realbase= realpath($dirname);
	$realdir = realpath($dir);
	$created = false;

	$realdir = substr($realdir,strlen($realbase));
	$tocheck = realpath($thumbdir."/".$dirname);
	$checkdirs = explode("/",$realdir);
	foreach ($checkdirs as $a=>$c) {
		$tocheck = $tocheck."/".$c;
		if(file_exists($authfile=$tocheck."/authorized.txt")){
			if(isset($allowed))	
				$allowed=array_intersect($allowed,file($authfile));
			else
				$allowed=file($authfile);
		}
	}
	return $allowed;
}

/* allowed
* checks if the visitor is allowed to see this amazing stuff
*/
function allowed($dir){
	$allowed=list_allowed($dir);
	return (sizeof($allowed)==0 || sizeof(array_intersect($allowed,$groups)) > 0);
}

/* list_dirs($dir)
* returns a list of the directories of $dir
*/
function list_dirs($dir){
	$dirlist=array();
	if(allowed($dir)){
		$d=opendir($dir);
		while ($file=readdir($d)){
			if($file!="." && $file!=".." && is_dir($dir.$file)) $dirlist[]=$dir.$file;
		}
	}
	return $dirlist;
}

/* menubar_button($name)
* Returns the menubar button div associated to $name
*/
function menubar_button($name,$content){
	$curr_pos=0;
	if(isset($_SESSION['image']) && isset($_SESSION['images'])) $curr_pos=array_search($_SESSION['image'],$_SESSION['images']);
	if($name=="next"){
		$next_pos=$curr_pos+1;
		if($next_pos>sizeof($_SESSION['images'])) $next_pos=$curr_pos;
		$nextimg=$_SESSION['images'][$next_pos];
		return "<div id='$name' class='menubar_button'><a href=\"./index.php?image=$nextimg\">$content</a></div>\n";
	}
	if($name=="previous"){
		$next_pos=$curr_pos-1;
		if($next_pos<0) $next_pos=0;
		$nextimg=$_SESSION['images'][$next_pos];
		return "<div id='$name' class='menubar_button'><a href=\"./index.php?image=$nextimg\">$content</a></div>\n";
	}
	return "<div id='$name' class='menubar_button'><a>$content</a></div>\n";
}

/* menubar
* Creates the menu bar, according to user's settings
*/
function menubar(){
	require "settings.php";
	
	echo("<div id='menubar_left'>\n");
	for($i=0;$i<sizeof($menubar_left);$i++){
		echo menubar_button($menubar_left[$i],$buttons[$menubar_left[$i]]);
	}
	echo("</div>\n<div id='menubar_center'>\n");
	for($i=0;$i<sizeof($menubar_center);$i++){
		echo menubar_button($menubar_center[$i],$buttons[$menubar_center[$i]]);
	}
	echo("</div>\n<div id='menubar_right'>\n");
	for($i=0;$i<sizeof($menubar_right);$i++){
		echo menubar_button($menubar_right[$i],$buttons[$menubar_right[$i]]);
	}
	echo("</div>\n");
}

/* action
* Does coffee. Real nice coffee.
*/
function action($f){
	require_once('settings.php');
	$session_vars=array("image","album","albumname","layout","action");

	GLOBAL $image, $album, $albumname, $page, $layout, $action;

	foreach ($session_vars as $a){
		if($a == "layout") $$a = "album";
		if(isset($_SESSION[$a])) $$a=$_SESSION[$a];
	}
	
	if($f=="") return;

	if($f=="go_on"){
		$f		=	$album;
	}else{
		$page		=	0;
	}

	if(!check_path($f) || !file_exists($f)) return -1;
	
	if(is_dir($f)){
       		// This is an album
        	$album		=	$f;
        	$albumname	=	basename($album);
        	$action		=	"album";
//			$images		=	load_images($album,$groups,$thumbdir,1);
//        	$image		=	$images[0];
			$layout		=	"album";
		
	}else if(is_file($f)){
        	// This is a picture
    		$album          =       dirname($f);
    		$albumname      =       basename($album);
			if(allowed($f)){
        		$image          =       $f;
        		$action         =       "image";
				$layout			=		"image";
			}else{
				$action			=	"album";
				$layout			=	"album";
			}
	}
		
	foreach ($session_vars as $a) {
		$_SESSION[$a]=$$a;
	}
	return 0;
}

function rssupdate($urlimg,$urlbase,$title,$type,$art_t){
	if($type=="photos"){
		$feed_f="./photos.xml";
		$art_title="New Photo !";
	}elseif($type=="albums"){
		$feed_f="./albums.xml";
		$art_title="New Album : ".addslashes($art_t);
	}elseif($type=="comments"){
		$feed_f="./comments.xml";
		$art_title="New Comment !";
	}

	if(!is_file($feed_f)){
		$r_f = fopen($feed_f,"w+");
		fwrite($r_f,"<rss version='2.0'><channel><title>$title</title>\n</channel></rss>");
		fclose($r_f);
	}
	$buffer="<item><title>$art_title</title><description><img src='$urlimg'/></description><link>$urlbase</link><pubDate>".date('r')."</pubDate></item>\n";
	$r_f=file($feed_f);
	$arr_tmp = array_splice($r_f,1);
    	$r_f[] = $buffer;
    	$r_f = array_merge($r_f,$arr_tmp);
	if(sizeof($r_f)>22){
		array_splice($r_f,20);
		$r_f[]="</channel></rss>";
	}
   
	$r_file=fopen($feed_f,"w+");
	foreach($r_f as $k => $v){
		fwrite($r_file,$v);
	}
	fclose($r_file);
}

/* display_thumbnails
* displays $num thumbnails taken fom the $images array
*/
function display_thumbnails($images,$first,$num){
	require "settings.php";
	
	for($i=$first;$i<$first+$num && $i < sizeof($images);$i++)
	{	
		$images[$i] = str_replace("./","",$images[$i]);


		if(strpos($images[$i],"/.")===false && !is_dir($images[$i]) && is_file($images[$i]) && substr($images[$i],-3,3) != "php" && substr($images[$i],-3,3) != "xml" && substr($images[$i],-3,3) != "txt")
		{

			$thumbname=$thumbdir.$images[$i];
			$smallpic = substr_replace($thumbname, "/s_", strrpos($thumbname, "/"), strlen("/"));

			if(!is_file($thumbdir.$images[$i]))
			{
					$x=100;
					$y=100;
					$src=$images[$i];
					$dest=$thumbdir.$images[$i];
					$dirs=explode("/",$images[$i]);
					$rssimg=$dest;
					$srcdir=substr($src,0,strrpos($src,"/"));
					$authfile=$thumbdir."/".$srcdir."/authorized.txt";
					for($sec=0;$sec<sizeof($dirs);$sec++){
						$tempvar=$thumbdir;
						for($sectemp=0;$sectemp<$sec;$sectemp++){
							$tempvar="$tempvar/$dirs[$sectemp]";
						}
						if(!is_dir($tempvar)){
							mkdir($tempvar);
							chmod($tempvar,0777);
							if(!is_file($authfile)&& $url!='' && $sec+1==sizeof($dirs)){
								if($slow_conn) $rssimg=$smallpic;
								rssupdate($url.$rssimg,$url."index.php?f=".$srcdir,$title,"albums",substr($srcdir,strrpos($srcdir,"/")+1));
							}
						}
					}
					require "thumb.php";
					if(!is_file($authfile)&& $url!=''){
						if($slow_conn) $rssimg=$smallpic;
						rssupdate($url.$rssimg,$url."index.php?f=".$src,$title,"photos");
					}
			}

			if(!is_file($smallpic) && $slow_conn)
			{
					$x=800;
					$y=600;
					$src=$images[$i];
					$dest=$smallpic;
					$dirs=explode("/",$images[$i]);
					for($sec=0;$sec<sizeof($dirs);$sec++){
						$tempvar=$thumbdir;
						for($sectemp=0;$sectemp<$sec;$sectemp++){
							$tempvar="$tempvar/$dirs[$sectemp]";
						}
						if(!is_dir($tempvar)){
							 mkdir($tempvar);
							 chmod($tempvar,0777);
						}
					}
					$dimensions = getimagesize($src);
					if($dimensions && $dimensions[0] <= 800 && $dimensions[1] <= 600) {
						copy($src,$dest);
					}else{
						//echo ("<script>$.post('thumb.php',{ x: 800, y: 600, src: '$src', dest:'$dest' }); </script>");
						require "thumb.php";
					}
			}
			if(isset($_SESSION['image'])){
				if("./".$images[$i]==$_SESSION['image']){
					$curr_select="select";
				}else{
					$curr_select="";
				}
			}
			echo ('
				<li class="list_item">
				<a title="'.$images[$i].'" href="?f='.$images[$i].'" > 
				<div class="img_contain"><div class="around_img '.$curr_select.'"><img src="'.$thumbdir.$images[$i].'"/></div></div>
				</a>
				</li>
			');
		}

	}

}

/* array_to_ret
* Returns a string containing the "get" structure of the array, with name $name
*/
function array_to_get($array,$name){
	$ret="";
	for($i=0;$i<sizeof($array);$i++){
		$ret="$ret&$name\[\]=$array[$i]";
	}
	return $ret;
}

/* log_me_in
* Checks the login/pass of a user
*/

function log_me_in($name,$pass){
	define("ME_IZ_GOOD","TRUE");
	require "pass.php";
	define("ME_IZ_GOOD","FALSE");	
	return ($groups[$name]==sha1($pass));
//	return (in_array($name.":".sha1($pass),$groups));
}

function check_path($album){
	require 'settings.php';
	$myscope=realpath($dirname);
	$path_required=realpath($album);

	return (strncmp($path_required, $myscope, strlen($myscope)) == 0);
}

	
/* load_images
* loads the images inside a folder. Recursively if $recursion==true.
*/
function load_images($album,$groups,$thumbdir,$recursion){
	if(strpos("..",$album)>-1) return;
	
	if(check_path($album) == 0) return;
	if(!allowed($album)) return;
/*
	if (is_file($thumbdir."/".$album."/authorized.txt")){
		$lines=file($thumbdir."/".$album."/authorized.txt");
		foreach($lines as $line_num => $line)
			$authorized[]=substr($line,0,strlen($line)-1);  // substr is here for taking care of the "\n" 
		if(sizeof(array_intersect($groups,$authorized))==0) return;
	}
*/
	$dir = scandir($album); 

	for($i=0;$i<sizeof($dir);$i++) 
	{
		$file=$album."/".$dir[$i];
		if(is_file($file)) 
			$images[]=$file;
		else if(is_dir($file) && substr($file,-1,1)!="."){ 
			$images_new=load_images($file,$groups,$thumbdir,$recursion);
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
