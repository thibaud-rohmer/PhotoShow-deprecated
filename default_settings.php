<?php
/*
*  Created by Thibaud Rohmer on 2010-12-26.
*/


/******* Main settings *******/

// Website title
$title 		=	"PhotoShow";

// Main directory
$dirname	=	"./photos/"; 

// Directory where you store your virtual albums  (if doesn't exists, "Virtual" isn't displayed on the website)
$virtual	=	"./virtual/"; 

// Directory where the thumbnails are created
$thumbdir	=	"./thumb/"; 

// Max number of images per page
$limit		=	25; 

// Website theme (design)   choices available :   black_knight   snow_white
$theme		=	"black_knight";

// Theme modification (only for snow_white at the moment)   choices available :   purple
$mod		=	"";

/******* Left Menu *******/


/** Choose what is displayed **/

// Generated album : All images sorted by age
$by_age_all		=	true;

// Generated album : Images of each album sorted by age 
$by_age_albums	=	true;

// Generated album : All images in random order
$random_all		=	true;

// Generated album : Images of each album in random order
$random_albums	=	true;

// Albums : Well.. if you want to display your albums (hey, some just want generated albums)
$real_albums	=	true;



/** Choose section names **/

// Generated folders : displayed title
$generated_title =	"Library";

// Sorted by age folders : displayed title
$age_title 		=	"By age";

// Randomly sorted folders : displayed title
$random_title 		=	"Random";




/******* Menubar *******/

$buttons=array();

// Edit button names
$buttons["help"]	=	"HELP";
$buttons["previous"]=	"<";
$buttons["next"]	=	">";
$buttons["exif"]	=	"EXIF";
$buttons["comments"]=	"COMMENTS";
$buttons["fblike"]	=	""; // Doesnt work great yet...

// Left side of menu bar : buttons
$menubar_left 		=	array("exif","comments");

// Center of menu bar : buttons
$menubar_center		=	array("previous","next");

// Right side of menu bar : buttons
$menubar_right 		=	array("help");


/******* Global *******/

// Sorts all pictures in the albums by age instead of sorting by name
$sort_all_by_age	=	false;

?>