<?php

require_once('settings.php');
require_once('functions.php');
if(isset($_GET['dir'])){
	$images=load_images($_GET['dir']);
}else{
	die ('No directory selected');
}

$got_img=1;
if(isset($_GET['page'])){
	$got_img=0;
	$page=$_GET['page'];
	echo "<div class='gallery-row'>";
	for($i=$page*3; $i<(1+$page)*3 && $i<sizeof($images);$i=$i+1){
		$im=$images[$i];
		echo "<div class='gallery-item'><a href=\"$im\"><img src=\"$thumbdir/$im\"></a></div>";
		$got_img=1;
	}
}

$dir=$_GET['dir'];
$page=$page+1;
?>

<?php if(isset($_GET['page'])) {
	if($got_img==1){ 
	echo("<script type=\"text/javascript\">
	$(document).ready(function(){
		$.post(\"m_gallery.php?page=$page&dir=$dir\" ,function(data){ 
			$(data).appendTo('#Gallery');
		});
	});
	</script>
	");
	}
	die();
}
?>


<html>
        <head> 
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <meta name="author" content="Thibaud Rohmer" >

                <link rel="icon" type="image/ico" href="favicon.ico">
        <link rel="stylesheet" href="./stylesheets/mobile.css" />
        <title><?php echo "$title"; ?></title> 
        <script type="text/javascript" src="./jQuery/jquery.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$.post("m_gallery.php?page=<?php echo "0&dir=$dir";?>" ,function(data){ 
			$(data).appendTo('#Gallery');
		});
	});
	</script>

	</head>
	<body>

<div data-role="page" data-theme="b" id="index">
<div data-role="Header">
<a href="./m.php">Back</a>
</div>

<div id="MainContent">
	
	<div data-role="page-content">
	<div id="Gallery">
	</div>
	</body>
</html>
