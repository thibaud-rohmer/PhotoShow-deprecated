<div id="close_exif" class="menubar_button"><a href="#">x</a></div>
<?php
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
$("#close_exif a").click(function(){
	$("#exif").toggle("slow");
});
</script>