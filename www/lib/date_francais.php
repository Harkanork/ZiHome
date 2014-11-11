<?
function date_francais($date){
  if (preg_match ('`^(\d{4})-(\d{2})-(\d{2})(.*)$`', $date, $out))
  {
    return $out[3].'-'.$out[2].'-'.$out[1].'  '.$out[4];
  }
  else
  {
    return $date;
  }
}

function date_simplifiee($date){
  if (preg_match ('`^(\d{4})-(\d{2})-(\d{2}) (.*):(\d{2})$`', $date, $out))
  {
    $hier=$out[3]+1;
    if (date("d-m-Y")==$out[3].'-'.$out[2].'-'.$out[1]) 
    {
      return 'Aujourd\'hui &agrave;  '.$out[4];
    }
    elseif (date("d-m-Y")==$hier.'-'.$out[2].'-'.$out[1])
    {
      return 'Hier &agrave; '.$out[4];
    }
    else
    {
    return $out[3].'-'.$out[2].'-'.$out[1].'  '.$out[4];
    }    
  }
  else
  {
    return $date;
  }
}

function date_ISO($date){
  if (preg_match ('`^(\d{2})-(\d{2})-(\d{4})(.*)$`', $date, $out))
  {
    return $out[3].'-'.$out[2].'-'.$out[1].'  '.$out[4];
  }
  else
  {
    return $date;
  }
}
?>
