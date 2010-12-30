<?php
require_once "functions.php";

$name=$_POST['name'];
$pass=$_POST['pass'];

if(isset($name) && log_me_in($name,$pass)){
		$_SESSION["groups"][]=$name;
		echo "You are now logged into the groups : ";
		foreach($_SESSION["groups"] as $line_num => $group_name)
			echo "$group_name ";
}else{
?>

<script type="text/javascript">
    function logme(){
		setup_keyboard();
		var myname=$('input:text').val();
		var mypass=$('input:password').val();
		$("#logindivcontent").load('login.php', { name: myname, pass: mypass } );
	}
	
	$(document).ready(function() {	
        $('#logmein').click(function(){
			logme();
		});
		$('input').focus(function(){
			remove_keyboard();
		});
    });       
</script>

<p>Please login to access this album :</p>
<form accept-charset="utf-8" >	
	Group name :<p><input type="text" name="name"></p>
	Password :<p><input type="password" name="pass"></p>
	<div id="logmein">Validate</div>
</form>
<?php
}
?>