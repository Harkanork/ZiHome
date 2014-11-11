<?php
  $ipAddress=$_SERVER['REMOTE_ADDR'];
  $macAddr=false;
  exec('/usr/sbin/arp -n ' . $ipAddress, $arp, $arp_ret);
  if ($arp_ret != 0)
  {
    exec('arp -n ' . $ipAddress, $arp, $arp_ret);
  }
  foreach($arp as $line)
  {
     $cols=preg_split('/\s+/', trim($line));
     if ($cols[0]==$ipAddress)
     {
         $macAddr=$cols[2];
     }
     else if ($cols[1] == '(' . $ipAddress . ')')
     {
         $macAddr=$cols[3];
     }
  }
?>
