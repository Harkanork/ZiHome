<?php
  $ipAddress=$_SERVER['REMOTE_ADDR'];
  $macAddr=false;
  
  // linux ?
  exec('/usr/sbin/arp -n ' . $ipAddress, $arp, $arp_ret);
  if ($arp_ret != 0)
  {
    // essaie encore ?
    exec('arp -n ' . $ipAddress, $arp, $arp_ret);
    if ($arp_ret != 0)
    {
      // Windows ?
      exec('arp -a ' . $ipAddress, $arp, $arp_ret);
    }
  }
  

  foreach($arp as $line)
  {
     $cols=preg_split('/\s+/', trim($line));
     if ($cols[0]==$ipAddress)
     {
         $macAddr=$cols[1];
     }
     else if ($cols[1] == '(' . $ipAddress . ')')
     {
         $macAddr=$cols[3];
     }
  }
?>
