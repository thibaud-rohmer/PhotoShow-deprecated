<?php

require_once "functions.php";

$name=$_POST['name'];
$pass=$_POST['pass'];
$album=$_POST['album'];

if(isset($name) && log_me_in($name,$pass)){
		$_SESSION["groups"][]=$name;
		if($album!=''){
			echo "<script>$('#logindiv').fadeOut('slow'); $('#projcontent').load('files.php', { action: 'album', album: '$album'});</script>";
		}
		echo "You are now logged into the groups : ";
		foreach($_SESSION["groups"] as $line_num => $group_name)
			echo "$group_name ";
}else{
	echo "<script>var myalbum='$album';</script>";
?>

<script type="text/javascript">

	function logme(myalb){
		setup_keyboard();
		var myname=$('#logindiv input:text').val();
		var mypass=$('#logindiv input:password').val();
		$("#logindiv").children().first().load('login.php', { name: myname, pass: mypass, album: myalb } );		
	}
	
	$(document).ready(function() {	
        $('#logmein').click(function(){
			logme(myalbum);
		});
		$('input').focus(function(){
			remove_keyboard();
		});
		
		$(".close").click(function(){
			$(this).parent().parent().fadeOut("slow");
		});
	});   
</script>
<?php if(!$included) { ?>
<div class="close">
	<a href="#">x</a>
</div>

<p>Please login to access this album :</p>
<?php
}
?>
<form accept-charset="utf-8" >	
	Group name :<p><input type="text" name="name"></p>
	Password :<p><input type="password" name="pass"></p>
	<div id="logmein" class="formvalidate">Validate</div>
</form>
<?php
}
?>
