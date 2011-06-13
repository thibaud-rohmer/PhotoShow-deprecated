<?php

require_once('settings.php');
require_once('functions.php');

?>

<!DOCTYPE html> 
<html> 
	<head> 
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="author" content="Thibaud Rohmer" >

		<link rel="icon" type="image/ico" href="favicon.ico">
	<title><?php echo "$title"; ?></title> 
	<link rel="stylesheet" href="./stylesheets/jquery.mobile.min.css" />
	<script type="text/javascript" src="./jQuery/jquery.min.js"></script>
	<script type="text/javascript" src="./jQuery/jquery.mobile.min.js"></script>
</head> 
<body> 

<div data-role="page" data-theme="b" id="index">
	<div data-role="header">
		<h1><?php echo "$title";?></h1>
	</div><!-- /header -->

	<div data-role="content">
<?php
$albums = list_dirs($dirname);
foreach($albums as $a){
	$base=basename($a);
	$albs=list_dirs($a."/");

	echo("
	<ul data-role='listview' data-inset='true' data-theme='c' data-dividertheme='b'>
		<li data-role='list-divider'>$base</li>
	");
	foreach ($albs as $b){
			$nice=basename($b);
			echo "<li><a href=\"./m_gallery.php?dir=$b\" rel='external'>$nice</a></li>";
	}
	echo('</ul>');	
}
?>
	</div>
</div>
</body>

</html>
