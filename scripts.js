/*
*  Created by Thibaud Rohmer on 2010-12-23.
*/

/* 	refresh_img
*	loads given image url in the fullscreen (fs) and display (display_img) divs 
*	and updates exif panel
*/

function refresh_img(url){
	if(url=="" || url==undefined){
		$('#display_img').html("");
		$('#exifdiv .content').html("");
		$('#commentsdiv .content').html("");
		$("#fblike").html("");
		return false;
	}
	
	if(slow_conn){
		mypos=url.lastIndexOf("/");
		small_url = thumbdir + url.substr(0,mypos) + "/s_" + url.substr(mypos+1);
		$('#display_img').html('<span></span><a href="'+small_url+'"><img src="'+small_url+'"/></a>');
		$('#fs_img').html('<img src="'+small_url+'"/>');
	}else{
		$('#display_img').html('<span></span><a href="'+url+'"><img src="'+url+'"/></a>');
		$('#fs_img').html('<img src="'+url+'"/>');
	}


	$("#fblike").html('<iframe src="http://www.facebook.com/plugins/like.php?layout=button_count&amp;action=like&amp;colorscheme=dark&amp;height=20&amp;ref='+escape(location.href.replace("#",""))+'&amp;href='+escape(location.href.replace("#",""))+'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px;" allowTransparency="true"></iframe>');

	$('#exifdiv .content').load('exif.php',{ img: url });
	$("#exif").show();

	$('#admindiv .content').load('admin.php',{ img: url });

	$('#commentsdiv .content').load("infos.php",{ file: url });
	$('#largeimg').html("<a href='"+url+"'>IMG</a>");

	$('#display_img a').click(function(){ 
		change_display();
		return false;
	});

	location.hash=encodeURI(url);
	
}


function update_title(title){
	document.title = title;
}

/* show_select
* Brings focus to selected image
*
*/
function show_select(direction){
	if(typeof($(".select").attr("class")) != 'undefined'){
		var number=($(window).width()-$("leftcolumn").width())/3;
		item=$('.select');
		for(i=0;i<number;i=i+$(".img_contain").first().width()){
			if(typeof($(item).prev().attr("class")) != 'undefined'){
				item=$(item).prev();
			}
		}
		$('#projcontent').scrollTo($(item));
	}
}

/* select_thumb(thumb)
* selects the thumb
*/
function select_thumb(thumb){
	if($(thumb).attr("class") != "list_item") return false;
	$(".select").removeClass("select");
	thumb.addClass("select");
	return true;
}

/* 	preload_next
*	loads next image in memory for future viewing
*	
*/
function preload_next(){
	if(typeof($(".select").prev().attr("class")) != 'undefined'){
		if($(".select").next().attr("class") != 'list_item'){
			$('.end').trigger('click');
		}
	
		url=$(".select").next().children("a").attr("title");

		if(slow_conn){
			mypos=url.lastIndexOf("/");
			url = thumbdir + url.substr(0,mypos) + "/s_" + url.substr(mypos+1);
		}


		nextImage = new Image(); 
		nextImage.src = url;
	}
}

/* 	preload_prev
*	loads previous image in memory for future viewing
*	
*/
function preload_prev(){
	if(typeof($(".select").prev().attr("class")) != 'undefined'){
		url = $(".select").prev().children("a").attr("title");

		if(slow_conn){
			mypos=url.lastIndexOf("/");
			url = thumbdir + url.substr(0,mypos) + "/s_" + url.substr(mypos+1);
		}


		nextImage = new Image(); 
		nextImage.src = url;
	}
}

/* 	select_next
*	selects and displays next image
*	and preloads the next one
*/
function select_next(){
	if(typeof($(".select").attr("class")) == 'undefined'){
		$("#projcontent ul li").first().addClass("select");
		refresh_img($(".select a").attr('title'));
	}else{	
		if(typeof($(".select").next().attr("class")) != 'undefined'){
			if( ! select_thumb($(".select").next())){
				$(".select").next().trigger("click");
			}
			refresh_img($(".select a").attr('title'));			
		}
	}
	show_select("right");
	preload_next();
}

/* 	select_prev
*	selects and displays previous image
*	and preloads the one even before
*/
function select_prev() {
	if(typeof($(".select").attr("class")) == 'undefined'){
		$("#projcontent ul li").last().addClass("select");
		refresh_img($(".select a").attr('title'));
	}else{
		if(typeof($(".select").prev().attr("class")) != 'undefined'){
			var act=$(".select");
			$(".select").prev().addClass("select");
			act.removeClass("select");
			refresh_img($(".select a").attr('title'));		  
		}
	}
	show_select("left");
	preload_prev();
}

/* 	del_select_next
*	deletes current image, then selects and displays next image
*	and preloads the next one
*/
function del_select_next(){
	current=$(".select");
	select_next();
	current.hide();
	current.remove();
}

/* Diaporama */

var diapo=0;
var diapoId=0;
	
function diaporama(){
	if(diapo==1){
		$("#fs").show();
		diapoId = setInterval(select_next,3000);
	}else{
		$("#fs").hide();
		clearInterval(diapoId);
		diapoId=0;
	}
}	

function pause_diaporama(){
	if(diapo==1){
		if (diapoId==0){
			diapoId = setInterval(select_next,3000);
		}else{
			clearInterval(diapoId);
			diapoId=0;
		}
	}
}

/* remove_keyboard
* removes keyboard shortcuts
*/
function remove_keyboard(){	
	$(window).unbind("keydown");
}

/* setup_keyboard
* setups keyboard shortcuts
*/
function setup_keyboard(){	
	remove_keyboard();
	
	$(window).keydown(function(event) {

		if (event.keyCode == '39') { // arrow right
			select_next();
	   	}
		if (event.keyCode == '37') { // arrow left
				select_prev();
		}
		if (event.keyCode == '40') { //arrow down
			var number=($(window).width()-360)/170;
			for(i=0;i<number;i++){
				select_next();
			}
	   	}
		if (event.keyCode == '38') { //arrow up
			var number=($(window).width()-360)/170;
			for(i=0;i<number;i++){
				select_prev();
			}
	   	}
	  	if (event.keyCode == '70') { // f
			if(diapo!=1){
				$("#fs").toggle();
			}
	   	}
	  	if (event.keyCode == '72') { // h
			$('#wtf .content').load('help.txt');
			if($("#wtf").is(":visible")){
				$("#wtf").fadeOut("slow");
			}else{
				$("#wtf").fadeIn("slow");
			}
	   	}
	  	if (event.keyCode == '69') { // e
			if($("#exifdiv").is(":visible")){
				$("#exifdiv").fadeOut("slow");
			}else{
				$("#exifdiv").fadeIn("slow");
			}
	   	}
	  	if (event.keyCode == '13') { // enter
			change_display();
	   	}

	  	if (event.keyCode == '27') { // escape
			if($("#fs").is(":visible")) {
				$("#fs").hide();
				if(diapo==1){
					diapo=0;
					diaporama();
				}
			}else{
				if($("#projcontent").hasClass("inline")) {
					change_display();
				}else{
					$(".select").removeClass("select");
   				}
			}
		}

	  	if (event.keyCode == '68') { // d
			diapo=1-diapo;
			diaporama();
		}
		
		if (event.keyCode == '32') { // space
			pause_diaporama();
		}

		if (event.keyCode == '79') { // o

		}
		
	});
}


/* 	change_display
*	toggles display_div visibility along with many other things...
*/
function change_display(val){
	
	//if(val!="init" && $("#display2").css("display")=="none"){
	if(val!="init" && $("#projcontent").hasClass("fullpage")){
		$("#projcontent").removeClass("fullpage").addClass("inline");
		$("#menubar").show().removeClass("menubar-fullpage").addClass("menubar-inline");
		$("#display2").fadeIn();
		$('#display_img a').unbind();
		$('#display_img a').click(function(){ 
			change_display();
			return false;
		});

		$(window).bind('mousewheel', function(event,delta){			
		 	if (delta > 0) {
				$("#projcontent").scrollTo('-='+10*delta+'px',0);
		 	} else {
				$("#projcontent").scrollTo('+='+(-10*delta)+'px',0);
		 	}
		});

		
	}else{
		$('#display_img a').unbind();
		$("#display2").fadeOut();
		$("#projcontent").removeClass("inline").addClass("fullpage");		
		$("#menubar").hide().removeClass("menubar-inline").addClass("menubar-fullpage");
	}
	init_thumbs();
	show_select();
};

/* 	num_selected
*	returns the number of items selected
*
*/
function num_selected(){
	return $(".select a").size();
};

/* 	list_selected
*	returns a list of selected items
*/
function list_selected(){
	var mylist=new Array();
	$(".select a").each(function(){
		mylist[mylist.length] = ($(this).attr("href"));
	});
	return mylist;
};

/* 	list_selected_as_php
*	returns a php list of selected items in a string
*/
function list_selected_as_php(){
	var mylist="?";
	$(".select a").each(function(){
		mylist=mylist+"mylist[]="+($(this).attr("href"))+"&";
	});
	return mylist;
};

/* display_more
* Displays next thumbnails
*
*/
function display_more(page,limit,size_dir){
	morebutton="<li class='end'>More...</li>";
	
	$.post('files.php', {action:'go_on', page: page} ,function(data){ 
		$(data).appendTo('#album_contents');
		page++;		
		
		if((page)*limit + 2 < size_dir) 
		$(morebutton).appendTo('#album_contents');
		
		$('.end').click(function(){
			$(this).remove();
			if((page)*limit + 2 < size_dir)
			{
				display_more(page,limit,size_dir);
			}
		});
		
		init_thumbs();
		
	});
}

function init_thumbs(){
	if($("#projcontent").hasClass("fullpage"))
	{
		$('#projcontent a').unbind();
		
		$('#projcontent a').click(function(){ 
			$('.select').removeClass('select');			
			$(this).parent().addClass('select');
			refresh_img(this.title);
			change_display();
			return false;
		});
		
		
	}else{
		$('#projcontent a').unbind();

		$('#projcontent a').click(function(){
			if ($(this).parent().hasClass("select")) return false;
			$(".select").removeClass("select");
			$(this).parent().addClass("select");			
			refresh_img(this.title);
			return false;
		});

		$('#projcontent a').dblclick(function(){ 
			change_display(); 
			return false;
		});

	}
}

$(document).ready(function() {
	
/* Left menu */
	
	slow_conn=false;
	accordionCache = $('div#accordion');
  	$('.year', accordionCache).click( function () {
	
		$("#projcontent").load('files.php', { album: $(this).attr("title"), action: "album" });
		$('div.albums', accordionCache).removeClass('open');
		$('.year').removeClass('menu_selected');
		$('#leftcolumn li').removeClass('menu_selected');
		$('#logindiv').hide();
		location.hash=encodeURI($(this).attr("title"));
		$(this).addClass('menu_selected');
		$(this).next().addClass('open').slideDown('slow');
		$('div.albums:not(.open)', accordionCache).slideUp();
  	} );


	$("#leftcolumn li").click(function() {
		myclass=$(this).attr("class");
		if (myclass.indexOf(" ") > 1) {
			myclass=myclass.substr(0,myclass.indexOf(" "));
		}
		$("#projcontent").load('files.php', { album: $(this).attr("title"), action: "album" });
		$('#exif').hide();
		$('#logindiv').hide();
		$('#exifdiv').fadeOut("slow");	
		if(myclass=="album")	location.hash=encodeURI($(this).attr("title"));
		else location.hash=encodeURI(myclass+"_"+$(this).attr("title"));
		$("#leftcolumn li").removeClass('menu_selected');
		$(this).addClass('menu_selected');
	});
	
	$(".sortbutton a").click(function(){
		$(".sortbuttonselected").removeClass("sortbuttonselected");
		$("#projcontent").load('files.php', { sort: $(this).attr("title"), action: "album" });
		$(this).parent().addClass("sortbuttonselected");
	});

	$(".slowconn a").click(function(){
		slow_conn = !(slow_conn);
		$(this).parent().toggleClass("slowconnselected");
	});
/* Menubar */

	$("#next a").click(function(){		
		select_next();
	});
	
	$("#previous a").click(function(){
		select_prev();
	});
	
	$("#fullscreen a").click(function(){
		$("#fs").show();
	});

	$("#fs").click(function(){
		$("#fs").hide();
	});

	$("#help a").click(function(){
		$('#wtf .content').load('help.txt');
		if(!$("#wtf").is(":visible")){
			$("#wtf").fadeIn("slow",function(){
				$("body").click(function(){
					if($("#wtf").is(":visible")) {
						$("#wtf").fadeOut("slow");
						$("body").unbind("click");
					}
				});
			});
	
		}
	});


	$(".menubar_button").click(function(){
		var name="#"+$(this).attr("id")+"div";
		if($(name).is(":visible")){
			$(name).fadeOut("slow");
		}else{
			$(name).fadeIn("slow");
		}
		$(name).draggable();
	});
	
/* Keyboard events */
	setup_keyboard();
	
// Anchor
	parse_my_hash_dude();

});


/* parse_my_hash_dude
* hash parsing made easy... or not
*/


function parse_my_hash_dude(){
	if(location.hash.length>2){
		var hash=decodeURI(location.hash.substr(1));
		$('#exif').hide();
		$('#exifdiv').hide();	
		$("#menubar").show();
	
	lastslash = hash.lastIndexOf("/");
	
	if( lastslash < 0 )  
	{
		var myaction=hash.substr(0,hash.lastIndexOf("_"));
		var myalbum=hash.substr(hash.lastIndexOf("_")+1);
		$("#projcontent").load('files.php', { album: myalbum, action: myaction });
	}
	else
	{
		if( lastslash < hash.lastIndexOf( "." ) ){
			// IMAGE
			var myalbum = hash.substr(0,hash.lastIndexOf("/")+1);
			
			$("#projcontent").load('files.php', { album: myalbum, action: "album" },function(){
				refresh_img(hash);
				change_display();				
			});
		}else{
			// FOLDER
			$("#projcontent").load('files.php', { album: hash, action: "album" },function(){
				change_display("init");
			});
		}
	}
}
}
