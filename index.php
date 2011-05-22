<?php 
/*
*  Created by Thibaud Rohmer on 2010-12-23.
*/

require_once "functions.php";
require_once "settings.php"; 
require "trick.php";

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="author" content="Thibaud Rohmer" >

		<link rel="icon" type="image/ico" href="favicon.ico">
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

<?php

echo "<script>
thumbdir = '$thumbdir';
</script>";

?>
</head>
<body>
	<div id="fs">
		<div id="fs_img"></div>
	</div>
	<div id="loading">Generating Thumbnails...</div>
	<div id="wtf">
		<div class="content">Aide</div>
		<div class="bg"></div>
	</div>
	
	<div id="commentsdiv" class="panel">
		<div class="content">Aucun commentaire</div>
		<div class="bg"></div>
	</div>
		
	<div id="logindiv" class="panel">
		<div class="content">
		<?php 
			include "login.php"; 
		?>
		</div>
		<div class="bg"></div>
	</div>
	
	<div id="admindiv" class="panel">
		<div class="content"></div>
		<div class="bg"></div>
	</div>
	
	<div id="exifdiv" class="panel">
		<div class="content">EXIF</div>
		<div class="bg"></div>
	</div>

	
<div id="wrapper" >
	<div id="leftcolumn" >
		<div id="accordion"  >
			<?php require "folders.php"; ?>
		</div> 
		<div id="leftcolumnbottom">
			<?php if($slow_conn) echo '<div class="slowconn lcbbutton" ><a>SLOW CONNECTION</a></div>'; ?>
			<div class="sortbutton lcbbutton" ><a title='date_asc'>DATE ASC</a></div>
			<div class="sortbutton lcbbutton" ><a title='date_desc'>DATE DESC</a></div>
			<div class="sortbutton lcbbutton sortbuttonselected" ><a title='name'>NAME</a></div>
			<div class="lcbbutton" ><a href="feed.xml">RSS</a></div>
			<div class="lcbbutton" ><a href="edit_settings.php">ADMIN</a></div>
			<div id="author">Powered by <a href="https://github.com/thibaud-rohmer/PhotoShow">PhotoShow</a></div>
		</div>
	</div>

	<div id="right" >
<?php

	if($action=='image'){
		echo '<div id="menubar" class="menubar-inline">';
		menubar();
		echo '</div><div id="projcontent" style="display:visible;" class="inline">';
		include 'files.php';
		echo '</div><div id="display2" style="display:visible;">';
		if(is_file("./".$image)) echo "<div id='display_img'><a href='./index.php?action=album'><img src='./".addslashes($image)."'></a></div>";
		else echo "<div id='display_img'>Image not found !</div>";
	}else{
		echo '<div id="menubar" class="menubar-fullpage" style="display:none;">';
		menubar();
		echo '</div><div id="projcontent" class="fullpage">';
		include 'files.php';
		echo '</div><div id="display2" style="display:none;">';
		echo "<div id='display_img'></div>";
	}
?>
		</div>	
	</div>	
</div>	   

</body>
</html>
