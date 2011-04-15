<?php

require_once "functions.php";

$name=$_POST['name'];
$pass=$_POST['pass'];
$album=$_POST['album'];
if(!isset ($included)) $included=$_POST['inc'];

if(isset($name) && log_me_in($name,$pass)){
		$_SESSION["groups"][]=$name;
		if($album!=''){
			echo "<script>$('#logindiv').fadeOut('slow'); $('#projcontent').load('files.php', { action: 'album', album: '$album'});</script>";
		}
		echo "<script>$('admindiv').load('admin.php');</script>";
		echo "You are now logged into the groups : ";
		foreach($_SESSION["groups"] as $line_num => $group_name)
			echo "$group_name ";
}
	echo "<script>var myalbum='$album';</script>";
?>

<script type="text/javascript">

	function logme(div,myalb,myname,mypass){
		setup_keyboard();
		$(div).load('login.php', { name: myname, pass: mypass, album: myalb, inc: '1' } );
	}
	
	$(document).ready(function() {	
		$('.formvalidate').click(function(){
			logme($(this).parent(),myalbum,$(this).parent().find('input:text').val(),$(this).parent().find('input:password').val());
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

<p>Oh, look ! A login form !</p>
<?php
}
?>
<form accept-charset="utf-8" >	
	Group name :<p><input type="text" name="name"></p>
	Password :<p><input type="password" name="pass"></p>
	<div id="logmein" class="formvalidate">Validate</div>
</form>
