<?

function fch_tlo($taille){
global $size_unit;
if ($taille >= 1073741824)
{$taille = round($taille / 1073741824 * 100) / 100 . " Go";}
elseif ($taille >= 1048576)
{$taille = round($taille / 1048576 * 100) / 100 . " Mo";}
elseif ($taille >= 1024)
{$taille = round($taille / 1024 * 100) / 100 . " Ko";}
else
{$taille = $taille . " o";}
if($taille==0) {$taille="-";}
return $taille;
}

function fch_tlb($taille){
global $size_unit;
if ($taille >= 1073741824)
{$taille = round($taille / 1073741824 * 100) / 100 . " Gb";}
elseif ($taille >= 1048576)
{$taille = round($taille / 1048576 * 100) / 100 . " Mb";}
elseif ($taille >= 1024)
{$taille = round($taille / 1024 * 100) / 100 . " Kb";}
else
{$taille = $taille . " b";}
if($taille==0) {$taille="-";}
return $taille;
}

?>
