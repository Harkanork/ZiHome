<?php
  $ipAddress = $_SERVER['REMOTE_ADDR'];
  $macAddr = false;
  
  if ($ipAddress == $_SERVER['SERVER_ADDR'])
  {
    // Cas special lorsque le client est le serveur
    
    exec('ifconfig', $ifconfig, $ifconfig_ret);
    if ($ifconfig_ret == 0)
    {
      foreach($ifconfig as $line)
      {
        $macAddrPos = strpos($line, "HWaddr");
        if ($macAddrPos >= 0)
        {
          $macAddr=substr($line, ($macAddrPos + 7), 17);
          break;
        }
      }
    }
    else
    {
      exec('ipconfig /all', $ifconfig, $ifconfig_ret);
      if ($ifconfig_ret == 0)
      {
        foreach($ifconfig as $line)
        {
          $macAddrPos = strpos($line, "Adresse physique");
          if ($macAddrPos >= 0)
          {
            $macAddr=substr($line, ($macAddrPos + 42), 17);
            if ($macAddr != "00-00-00-00-00-00")
            {
              break;
            }
          }
        }
      }
    }
  }
  else
  {
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
  }
?>
