<?php 
/*
*  Created by Thibaud Rohmer on 2010-12-25. - Yup. Merry Christmas to you too.
*/
require_once 'settings.php';

if(!isset($_SESSION["logged"])){
	session_start();
	$_SESSION["logged"]=true;
}

$file=$_POST["file"];

if(!isset($_POST['addcom'])) $file=$thumbdir.substr($file,0,strrpos($file,".")).".xml";


if(is_file($file)){
	$library = simplexml_load_file($file);
}else{
	$library = new SimpleXMLElement("<library></library>");
}

/** In case the user posted a comment **/
if(isset($_POST["author"])) $author = $_POST["author"];
if(isset($_POST["comm"])) 	$comm = $_POST["comm"];

if(isset($author) && isset($comm)){

	$new_comment = $library->addChild('comment');
	$new_comment -> addChild('content',$comm);
	$new_comment -> addChild('author',$author);

	$library->asXML($file);
}

echo '<div id="commentsdivcontent">';
echo '<div id="close" class="menubar_button"><a href="#">x</a></div>';


/** Let's display those comms **/
foreach ($library->comment as $comment) {
	$cont=stripslashes(trim($comment->content));
	$auth=stripslashes(trim($comment->author));
	echo ("<div class='comment'>
			<div class='comm'>$cont </div> 
			<div class='author'>Written by: $auth </div>
		   </div>"); 
}



echo("
<script type='text/javascript'>

function addcom(){
	setup_keyboard();
	var myauthor=$('input[name$=\"author\"]').val();
	var mycomm=$('input[name$=\"comm\"]').val();
	if(myauthor.length < 1 || mycomm.length < 1){
		alert('Please fill all fields.');
	}else{
		$('#commentsdiv .content').load('infos.php', { author: myauthor, comm: mycomm, file: '$file', addcom: 'true' } );
	}
}");

?>

$(document).ready(function() {	
	$('#validate').click(function(){
		addcom();
	});
	
	
	$('input').focus(function(){
		remove_keyboard();
	});

	$("#close a").click(function(){
		$("#commentsdiv").fadeOut("slow");
	});
});    


</script>

<div class="addcomm">Add comment :</p>
<form accept-charset="utf-8" >	
	Name :<p><input type="text" name="author"></p>
	Comment :<p><input type="text" name="comm"></p>
	<div id="validate">Validate</div>
</form>
</div>
</div>