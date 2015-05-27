<div class="video_cadre" style="max-width:<? echo $width+20; ?>px">
	<?
	$refresh_image = (int)($fps);
	$dt = $delai_tentative*1000;
	$remote = explode(".", $_SERVER["REMOTE_ADDR"]);
	$local = explode(".", $_SERVER["SERVER_ADDR"]);
	if($remote[0] == $local[0] && $remote[1] == $local[1] && $remote[2] == $local[2]) {
		$src = $adloc;
	} else {
		$src = $adweb;
	}
	if (strpbrk($src,"?")==false) {
		$src.="?t=";
	} else {
		$src.="&t=";
	}
	?>
	<div class="video_titre">
		<div><? echo $libelle; ?></div>
	</div>
	<div class="video_img">
		<p><a href="<? echo $src; ?>"><img class="video" src="<? echo $src; ?>" <? 
    if ($refresh_image > 0) 
    { 
      ?>
      onload ='setTimeout(function() { src = src.substring(0, (src.lastIndexOf("t=") + 2)) + (new Date()).getTime() }, <? echo $refresh_image ?>)'
      onerror='setTimeout(function() { src = src.substring(0, (src.lastIndexOf("t=") + 2)) + (new Date()).getTime() }, <? echo $dt ?>)' <? 
    } 
    ?> alt='Non disponible'></a></p>
	</div>
</div>
