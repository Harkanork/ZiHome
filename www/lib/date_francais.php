<?
function date_francais($date){
preg_match ('`^(\d{4})-(\d{2})-(\d{2})(.*)$`', $date, $out);
return $out[3].'-'.$out[2].'-'.$out[1].'  '.$out[4];
}
?>
