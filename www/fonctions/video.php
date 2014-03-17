<div class="video">
<video>
<?
$remote = explode(".", $_SERVER["REMOTE_ADDR"]);
$local = explode(".", $_SERVER["SERVER_ADDR"]);
if($remote[0] == $local[0] && $remote[1] == $local[1] && $remote[2] == $local[2]) { $address = $periph['adresse']; } else { $address = $periph['adresse_internet']; }
?>
<source src="<? echo $address; ?>" width="<? echo $width; ?>" height="<? echo $height; ?>" controls autobuffer autoplay>
</video>
<div class="panel"></div>
</div>
