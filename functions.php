<?php 
session_start();
/*
*  Created by Thibaud Rohmer on 2010-12-23.
*/

/* generate_settings
* generates the settings.php file if it isnt there
*/
function generate_settings(){
	$tit='<?php $title="PhotoShow"; ?>';
	$dir='<?php $dirname="./photos/"; ?>';
	$vir='<?php $virtual="./virtual/"; ?>';
	$thu='<?php $thumbdir= "./thumb/"; ?>';
	$lim='<?php $limit=25; ?>';

	@include "./settings.php";
	$settings = "./settings.php";
	$file = fopen($settings, 'a');
	
	if(!isset($title)){
		fwrite($file,$tit);
	}
	if(!isset($dirname)){
		fwrite($file,$dir);
	}
	if(!isset($virtual)){
		fwrite($file,$virt);
	}
	if(!isset($thumbdir)){
		fwrite($file,$thu);
	}
	if(!isset($limit)){
		fwrite($file,$lim);
	}
	
	if(!is_file())
}

/* sort_by_date
* sorts all of the pictures by date added on the server and returns an array
*/
function sort_by_date($groups){ 
	include "settings.php";
	$images=array();
	$folders= glob($dirname."*/*");
	
	foreach($folders as $folder_id => $folder){
		$authorized=array();
		if(is_file($folder."/authorized.txt")){
			$lines=file($folder."/authorized.txt");
			foreach($lines as $line_num => $line)
				$authorized[]=substr($line,0,strlen($line)-1);  // substr is here for taking car of the "\n" 
			
			if(sizeof(array_intersect($groups,$authorized))!=0){	
				$images=array_merge($images, glob($folder."/*"));
			}
		}else{
			$images=array_merge($images, glob($folder."/*"));
		}
	}
	
	array_multisort(array_map('filemtime', $images), SORT_DESC, $images); 
	return $images;
}


/* display_vignettes
* displays $num thumbnails taken fom the $images array
*/
function display_thumbnails($images,$first,$num){
	include "settings.php";
	define("IS_IN_MY_APP", "TRUE");
	
	
	for($i=$first;$i<$first+$num && $i < sizeof($images);$i++)
	{	
		$images[$i] = str_replace("./","",$images[$i]);
				
		if(strpos($images[$i],"/.")===false && !is_dir($images[$i]) && is_file($images[$i]) && substr($images[$i],-3,3) != "txt")	
		{

			if(!is_file($thumbdir.$images[$i]))
			{
					$x=100;
					$y=100;
					$src=$images[$i];
					$dest=$thumbdir.$images[$i];
					system("umask u=rwx,go=rx; mkdir -p ".$thumbdir.addslashes(substr($images[$i],0,strrpos($images[$i],"/"))));
					include "thumb.php";
			}

			echo ('
				<li class="list_item">
				<a title="'.$images[$i].'"> 
				<div class="img_contain"><div class="around_img"><img src="'.$thumbdir.$images[$i].'"/></div></div>
				</a>
				</li>
			');
		}

	}
	define("IS_IN_MY_APP", "FALSE");

}

/* array_to_ret
* Returns a string containing the "get" structure of the array, with name $name
*/
function array_to_get($array,$name){
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
	include "pass.php";
	define("ME_IZ_GOOD","FALSE");	
	return (in_array($name.":".sha1($pass),$groups));
}
?>