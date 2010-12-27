<?php 
/*
*  Created by Thibaud Rohmer on 2010-12-23.
*/

include "functions.php";
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
	<div id="wtf">
		<div class="content">Aide</div>
		<div class="bg"></div>
	</div>
	
<div id="wrapper" >
	<div id="leftcolumn" >
		<div id="accordion"  >
			<?php include("folders.php"); ?>
		</div> 
	</div>
	<div id="exifdiv">
		<div class="content">EXIF</div>
		<div class="bg"></div>
	</div>
	<div id="right" >
		<div id="menubar" style="display:none;">
			<?php menubar(); ?>			
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
