<?php
/*
*  Created by Thibaud Rohmer on 2010-12-23.
*/

if(!isset($_SESSION["logged"])){
	session_start();
	$_SESSION["logged"]=true;
}


require_once "settings.php";
$dir 	=	scandir($dirname); 


// Generated folders
	// This is for handling virtual folders
if(is_dir($virtual))
{
	echo ("<p> $virtual_title <p><div class='albums'><ul>");
	$virtual_dir=scandir($virtual);

	for($j=0;$j<sizeof($virtual_dir);$j++)
	{
		$file=$virtual_dir[$j];
		if(substr($file,strrpos($file,"/")+1,1) != '.' && !is_dir($file))
		{
			echo("<li 
			class='virtual'
			title='$virtual$file'
			> ".substr($file,strrpos($file,"/"),strrpos($file,"."))." </li>
			");
		}
	}
	echo "</ul></div>";
}

echo("<div class='year' class='real_album' title='$dirname'><a href=\"./index.php?f=$dirname\">ALL</a></div>");

if($real_albums)
{
	for($i=0;$i<sizeof($dir);$i++)
	{
		$subdirname=$dir[$i];
		$current_album=$dirname.$subdirname;
		if($subdirname != '.' && $subdirname != '..' && is_dir($current_album))
		{

			if($current_album==$_SESSION['album'] || $current_album == substr($_SESSION['album'],0,strrpos($_SESSION['album'],'/'))){
				echo("<div class='year real_album menu_selected' title=\"$current_album\"><a href=\"./?f=$current_album\"> $subdirname </a></div><div class='albums' style='display:visible;'><ul style='display:visible;'>");
			}else{
				echo("<div class='year real_album' title=\"$current_album\"><a href=\"./?f=$current_album\"> $subdirname </a></div><div class='albums' style='display:none;'><ul>");
			}

			$subdir=scandir($current_album,1);
			for($j=0;$j<sizeof($subdir);$j++) 
			{
				$file=$subdir[$j];
				if($file != '.' && $file != '..' && is_dir($current_album."/".$file) && $dirname.$file!=$virtual)
				{
					$myname=str_replace("_"," ",$file);

					$files=scandir($dirname.$subdirname."/".$file);
					$count=0;
					for($k=0;$k<sizeof($files);$k++)
					{
						$myfile=$files[$k];
						if(substr($myfile,0,6)!="thumb_" && substr($myfile,0,1)!="."  && substr($myfile,-3,3) != "php" && substr($myfile,-3,3) != "xml" && substr($myfile,-3,3) != "txt")
						{
							$count++;
						}
					}
					
					if($current_album.'/'.$file==$_SESSION['album']){
						echo "<li class='album menu_selected' title=\"$current_album/$file\">";
					}else{
						echo "<li class='album' title=\"$current_album/$file\">";
					}
					echo("<a href=\"./?f=$current_album/$file\">
					<div class='folder_name'>
					<div class='count'>".$count."</div>
					".$myname."
					</div>
					</a>
					</li>");
				}
			}
			echo ("</ul></div>");
		}
	}
}

?>


