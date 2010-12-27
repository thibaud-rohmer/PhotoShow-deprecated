<?php
/*
*  Created by Thibaud Rohmer on 2010-12-26.
*/

$title="PhotoShow";

$dirname="./photos/"; 

$virtual="./virtual/"; 

$thumbdir= "./thumb/"; 

$limit=25; 


$buttons=array();

$buttons["help"]	=	"HELP";
$buttons["previous"]=	"<";
$buttons["next"]	=	">";
$buttons["exif"]	=	"EXIF";
$buttons["fblike"]	=	""; // Doesnt work great yet...

$menubar_left 		=	array("exif");
$menubar_center	=	array("previous","next");
$menubar_right 	=	array("help");

?>