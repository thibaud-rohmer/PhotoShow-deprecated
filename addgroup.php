<?php
$name=$_POST['name'];
$pass=sha1($_POST['pass']);
if(isset($name)){
	echo("Please add this line to the 'pass.php' file : </p><p>$name:$pass</p>");
	die();
}

?>

<p>Add a group :</p>
<form action="addgroup.php" method="post" accept-charset="utf-8">	
	Group name :<p><input type="text" name="name"></p>
	Password :<p><input type="password" name="pass"></p>
	<p><input type="submit" value="Validate"></p>
</form>