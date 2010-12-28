<?php 
/*
*  Created by Thibaud Rohmer on 2010-12-25. - Yup. Merry Christmas to you too.
*/
include 'settings.php';

if(!isset($_SESSION["logged"])){
	session_start();
	$_SESSION["logged"]=true;
}

$file=$thumbir.substr($_POST["file"],0,strrpos($_POST["file"],".")).".xml";

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
	$cont=trim($comment->content);
	$auth=trim($comment->author);
	echo ("<div class='comment'>
			<div class='content'>$cont </div> 
			<div class='author'>Written by: $auth </div>
		   </div>"); 
}



echo("
<script type='text/javascript'>

function addcom(){
	setup_keyboard();
	var myauthor=$('input[name$=\"author\"]').val();
	var mycomm=$('input[name$=\"comm\"]').val();
	$('#commentsdiv .content').load('infos.php', { author: myauthor, comm: mycomm, file: '$file' } );
}");

?>

$(document).ready(function() {	
	$('#addcom').click(function(){
		alert("plip");
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

<p>Add comment :</p>
<form accept-charset="utf-8" >	
	Name :<p><input type="text" name="author"></p>
	Comment :<p><input type="text" name="comm"></p>
	<div id="addcom">Validate</div>
</form>

</div>