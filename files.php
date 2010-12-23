<?php
session_start();
// A ranger dans les options...
$dirname = "./photos/";
$thumbdir= "./thumb/";
$limit=25;


include "functions.php";


$action	= $_GET['action'];
$album 	= $_GET['album'];
$page 	= $_GET['page'];
$images = $_SESSION['images'];


if ($page < 1) echo ("<div id='null'></div><ul id='album_contents'>");


if($action=="album"){
	$images=array();
	$dir = scandir(urldecode($album)); 
	$size_dir=sizeof($dir);
	for($i=0;$i<sizeof($dir);$i++) 
	{
		$images[]=$album.$dir[$i];
	}

}elseif($action=="age"){
	$images=sort_by_date();
	$size_dir=sizeof($images);

}elseif($action=="virtual"){
	$images=array();
	$lines=file(stripslashes(urldecode($album)));
	foreach($lines as $line_num => $line)
		$images[]=$line;

}elseif($action=="go_on"){
	$size_dir=sizeof($images);
}


$_SESSION['images']=$images;
display_thumbnails($images,$page*$limit,$limit);	


$imagesphp=array_to_get($images,"album");

$nextpage=$page+1;


if ($page < 1) echo ("</ul><div class='end'>More...</div>");


if($page<1) {
	echo("
	<script>
	$(document).ready(function() {
		
		change_display('init');	
		var page = 0;
		
		if((page+1)*$limit + 2 >= $size_dir) {
			$('.end').remove();
		}
		
		$('.end').click(function(){
			page++;
			display_more(page);
		});
		
		function display_more(){
			if((page+1)*$limit + 2 >= $size_dir) {
				$('.end').hide();
			}
			$.get('./files.php?action=go_on&page='+page,function(data){ 
			$(data).appendTo('#album_contents'); 
			});
		}
		
	});
	</script>
	");

}else{
	echo ("
		<script>
		$('#projcontent a').unbind();
		$('#projcontent a').click(function(){ 
			$('.select').removeClass('select');
			$(this).parent().addClass('select');
			refresh_img(this.title);
			change_display(this.title); 
			$('#menubar').show()
			return false;
		});	
		</script>
		");
}
?>


