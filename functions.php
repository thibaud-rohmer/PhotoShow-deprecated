<?php 
/*
*  Created by Thibaud Rohmer on 2010-12-23.
*/

include "settings.php";


/* sort_by_date
* sorts all of the pictures by date added on the server and returns an array
*/
function sort_by_date(){ 
	include "settings.php";
	
	$images = glob($dirname."*/*/*");

	array_multisort(array_map('filemtime', $images), SORT_DESC, $images); 
	return $images;
}


/* display_vignettes
* displays $num thumbnails taken fom the $images array
*/
function display_thumbnails($images,$first,$num){
	include "settings.php";
	
	for($i=$first;$i<$first+$num && $i < sizeof($images);$i++)
	{	
		$images[$i] = str_replace("./","",$images[$i]);
				
		if(strpos($images[$i],"/.")===false && !is_dir($images[$i]))
		{
			if(!is_file($thumbdir.$images[$i]))
			{
				system("umask u=rwx,go=rx; mkdir -p ".$thumbdir.addslashes(substr($images[$i],0,strrpos($images[$i],"/"))));
				$mypage='thumb.php?src='.urlencode($images[$i]).'&dest='.urlencode($thumbdir.$images[$i]).'&x=100&y=100';
				echo('<script>$.get("'.$mypage.'");</script>');
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
?>