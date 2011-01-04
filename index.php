<?php 
/*
*  Created by Thibaud Rohmer on 2010-12-23.
*/

require_once "functions.php";
require_once "settings.php"; 

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="author" content="Thibaud Rohmer" >
		<title><?php echo $title ?></title>
		
		<?php 
		if(!is_dir("./stylesheets/$theme")) $theme="black_knight";
		
		echo("<link rel='stylesheet' href='stylesheets/$theme/basic.css' type='text/css' media='screen' title='no title' charset='utf-8'>\n");
		
		if(is_file("./stylesheets/$theme/basic.css"))
			echo("<link rel='stylesheet' href='stylesheets/$theme/$mod.css' type='text/css' media='screen' title='no title' charset='utf-8'>\n");
		
		?>
	
	<script src='jQuery/jquery.min.js' type="text/javascript" charset="utf-8"></script>
	<script src='jQuery/jquery-ui.min.js' type="text/javascript" charset="utf-8"></script>
	<script src="jQuery/jquery.scrollTo.js" type="text/javascript" charset="utf-8"></script>
	<script src="jQuery/jquery.mousewheel.js" type="text/javascript" charset="utf-8"></script>

	<script src="scripts.js" type="text/javascript" charset="utf-8"></script>

</head>
<body>
	<div id="fs">
		<div id="fs_img"></div>
	</div>
	<div id="wtf">
		<div class="content">Aide</div>
		<div class="bg"></div>
	</div>
	<div id="commentsdiv">
		<div class="content">Aucun commentaire</div>
		<div class="bg"></div>
	</div>
	
	
<div id="wrapper" >
	<div id="leftcolumn" >
		<div id="accordion"  >
			<?php require "folders.php"; ?>
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
		<div id="projcontent" class="fullpage">
		</div>	
		<div id="display2">
			<div id="display_img">
			</div>
		</div>
		
	</div>	
</div>	   

</body>
</html>
