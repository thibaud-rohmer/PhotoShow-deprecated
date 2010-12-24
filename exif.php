<div id="close" class="menubar_button"><a href="#">x</a></div>
<?php
/*
*  Created by Thibaud Rohmer on 2010-12-23.
*/

$exifDat=@exif_read_data($_GET['img']);

   if($exifDat)
   {

	$model=$exifDat["Model"];
	$lens=$exifDat["UndefinedTag:0x0095"];
	$ISO=$exifDat["ISOSpeedRatings"];
	$focal=$exifDat["FocalLength"]+0;
	$aperture=$exifDat["FNumber"]+0;
	$shutter=$exifDat["ExposureTime"];
	
		echo ("
			<div class='info_type1'> $model </div>
			<div class='info_type1'> $lens </div>
			<div class='exif_infos'>
			<div class='info_type2 border-right'>ISO $ISO</div>
			<div class='info_type2 border-right'>$focal mm</div>
			<div class='info_type2 border-right'>f/$aperture</div>
			<div class='info_type2'>$shutter</div>
			</div>");
			//*/
   }else{
	echo "<div class='info_type1'>No EXIF found.</div>";
}

?>
<script>
$("#close a").click(function(){
	$("#exif").fadeOut("slow");
});
</script>
