<?php
/*
*  Created by Thibaud Rohmer on 2010-12-23.
*/

if(!isset($_SESSION["logged"])){
	session_start();
	$_SESSION["logged"]=true;
}


require_once "settings.php";
$dir 	=	scandir(urldecode($dirname)); 

// Generated folders
if($by_age_all || $by_age_albums || $random_all || $random_albums || is_dir($virtual))
{

	echo("<div class='year'> $generated_title </div><div class='albums'><ul>");

	// Generated - By age
	if($by_age_all || $by_age_albums)
	{
		echo("<p> $age_title </p>");

		if($by_age_all) echo("<li class='age' title='*'>Everything </li>");

		if($by_age_albums)
		{
			for($i=0;$i<sizeof($dir);$i++) 
			{
				$subdirname=$dir[$i];
				if($subdirname != '.' && $subdirname != '..' && is_dir($dirname.$subdirname))
				{
					$myname=str_replace("_"," ",$subdirname);
					echo ("<li class='age' title='$subdirname'>$myname</li>");
				}
			}	
		}	
	}

	// Generated - Random
	if($random_all || $random_albums)
	{
		echo("<p> $random_title </p>");

		if($random_all) echo("<li class='random' title='*'>Everything </li>");

		if($random_albums)
		{
			for($i=0;$i<sizeof($dir);$i++) {
				$subdirname=$dir[$i];
				if($subdirname != '.' && $subdirname != '..' && is_dir($dirname.$subdirname))
				{
					$myname=str_replace("_"," ",$subdirname);
					echo ("<li class='random' title='$subdirname'>$myname</li>");
				}
			}		
			echo("</ul></div>");
		}
	}

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
}

if($real_albums)
{
	for($i=0;$i<sizeof($dir);$i++)
	{
		$subdirname=$dir[$i];
		if($subdirname != '.' && $subdirname != '..' && is_dir($dirname.$subdirname))
		{

			echo("<div class='year'> $subdirname </div><div class='albums'><ul>");

			$subdir=scandir($dirname.$subdirname,1);
			for($j=0;$j<sizeof($subdir);$j++) 
			{
				$file=$subdir[$j];
				if($file != '.' && $file != '..' && is_dir($dirname.$subdirname."/".$file) && $dirname.$file!=$virtual)
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

					echo("
						<li 
						class='album' 
						title='".urlencode($dirname).urlencode($subdirname)."/".urlencode($file)."/'
						><div class='folder_name'>
						".$myname."</div>
						<div class='count'>".$count."</div>
						</li>");
				}
			}
			echo ("</ul></div>");
		}
	}
}

?>


