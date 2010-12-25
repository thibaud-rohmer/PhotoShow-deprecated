<?php 
/*
*  Created by Thibaud Rohmer on 2010-12-23.
*/

include "settings.php"; 

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="author" content="Thibaud Rohmer" >
		<title><?php echo $title ?></title>
		
	<link href="stylesheet.css" rel="stylesheet" media="screen" type="text/css" >
	
	<script src='jQuery/jquery.min.js' type="text/javascript" charset="utf-8"></script>
	<script src='jQuery/jquery-ui.min.js' type="text/javascript" charset="utf-8"></script>

	<script src="scripts.js" type="text/javascript" charset="utf-8"></script>


</head>
<body>
	<div id="fs"></div>
	<div id="help">
		<div class="content">Aide</div>
		<div class="bg"></div>
	</div>
	
<div id="wrapper" >
	<div id="leftcolumn" >
		<div id="accordion"  >
			<?php include("folders.php"); ?>
		</div> 
		<?php echo $name; ?>
	</div>
	<div id="exif">
		<div class="content">EXIF</div>
		<div class="bg"></div>
	</div>
	<div id="right" >
		<div id="menubar" style="display:none;">
			<div id="menubar_left">
				<div id="ex" class="menubar_button" style="display:none;"><a href="#">EXIF</a></div>
			</div>
			<div id="menubar_center">
				<div id="prev" class="menubar_button"><a href="#"><</a></div>
				<div id="next" class="menubar_button"><a href="#">></a></div>
			</div>
			<div id="menubar_right">
				<div id="wtf" class="menubar_button"><a href="#">HELP</a></div>
			</div>				
		</div>
		
		
		<div id="projcontent" class="fullpage"></div>	
		<div id="display2">
			<div id="display_img">
			</div>
		</div>
		
	</div>	
</div>	   

</body>
</html>
